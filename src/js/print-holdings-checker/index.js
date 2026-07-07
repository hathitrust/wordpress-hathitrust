import { validateFile, validateRows, allowedTypes } from './validate.js';
import { buildCard, buildPendingCard, showError } from './ui.js';

// Fetch is CORS-blocked outside www.hathitrust.org (local dev, test); catch returns null and member ID check is silently skipped.
const memberIdsPromise = fetch('https://www.hathitrust.org/files/ht_institutions.tsv')
  .then(r => r.text())
  .then(text => new Set(text.split('\n').filter(Boolean).map(line => line.split('\t')[0])))
  .catch(() => null);

const outputContainer = document.getElementById('output');
const dropZone = document.getElementById('drop-zone');
const historySection = document.getElementById('history-section');
const historyList = document.getElementById('history-list');

// Persisted via localStorage so history survives a page reload/revisit.
const HISTORY_STORAGE_KEY = 'holdingsCheckerHistory';
const HISTORY_LIMIT = 10;

function readHistory() {
  try {
    return JSON.parse(localStorage.getItem(HISTORY_STORAGE_KEY)) ?? [];
  } catch {
    return [];
  }
}

function buildHistoryItem({ time, fileName, errorCount }) {
  const li = document.createElement('li');
  const status = errorCount > 0 ? `${errorCount} error${errorCount > 1 ? 's' : ''}` : 'No errors';
  li.textContent = `${new Date(time).toLocaleString()} - ${fileName}: ${status}`;
  return li;
}

function loadHistory() {
  if (!historyList) return;
  const entries = readHistory();
  if (entries.length === 0) return;
  historySection.style.display = 'block';
  for (const entry of entries) {
    historyList.appendChild(buildHistoryItem(entry));
  }
}

function addHistoryEntry(fileName, errorCount) {
  if (!historyList) return;
  historySection.style.display = 'block';
  const entry = { time: Date.now(), fileName, errorCount };
  historyList.prepend(buildHistoryItem(entry));

  const entries = readHistory();
  entries.unshift(entry);
  entries.length = Math.min(entries.length, HISTORY_LIMIT);
  try {
    localStorage.setItem(HISTORY_STORAGE_KEY, JSON.stringify(entries));
  } catch {
    // localStorage full or unavailable (e.g. private browsing), history just won't persist.
  }
}

loadHistory();

if (dropZone) {
  dropZone.addEventListener('drop', dropHandler);
  dropZone.addEventListener('dragover', dragOverHandler);
  dropZone.addEventListener('dragenter', dragEnterHandler);
  dropZone.addEventListener('dragleave', dragLeaveHandler);

  const fileInput = document.getElementById('file-input');
  document.getElementById('file-button').addEventListener('click', () => fileInput.click());
  fileInput.addEventListener('change', (event) => {
    const files = [...event.target.files];
    fileInput.value = ''; // reset so the same file can be re-selected after clearing results
    const invalid = files.filter(f => !isTextLikeFile(f.name));
    if (invalid.length > 0) {
      showError(outputContainer, `Only .tsv files are supported. Unsupported file${invalid.length > 1 ? 's' : ''}: ${invalid.map(f => f.name).join(', ')}`);
      return;
    }
    processFileList(files);
  });
}

// Blocks obviously wrong drops up front, but lets text-like extensions
// through so their filename/column/row problems are reported too.
// validateFilename() still flags the extension as an error.
function isTextLikeFile(fileName) {
  const lower = fileName.toLowerCase();
  return ['.tsv', '.txt', '.csv'].some(ext => lower.endsWith(ext));
}

function dragOverHandler(event) {
  event.preventDefault();
}

function dragEnterHandler(event) {
  event.preventDefault();
  event.currentTarget.classList.add('drag-over');
}

function dragLeaveHandler(event) {
  event.preventDefault();
  // relatedTarget is where the cursor moved to. If it's still inside #drop-zone (a child
  // element), this isn't a real "leave". only clear when it's outside, or null (the cursor
  // left the browser window entirely, which a counter can't detect since no dragleave fires).
  if (event.relatedTarget && event.currentTarget.contains(event.relatedTarget)) {
    return;
  }
  event.currentTarget.classList.remove('drag-over');
}

function dropHandler(event) {
  event.preventDefault();
  event.currentTarget.classList.remove('drag-over');

  const items = [...event.dataTransfer.items];
  for (const item of items) {
    if (item.kind === 'file') {
      const entry = item.webkitGetAsEntry();
      if (entry && entry.isDirectory) {
        showError(outputContainer, 'Folders cannot be dropped here. Please select individual .tsv files.');
        return;
      }
    }
  }

  const files = [...event.dataTransfer.files];
  const invalid = files.filter(f => !isTextLikeFile(f.name));
  if (invalid.length > 0) {
    showError(outputContainer, `Only .tsv files are supported. Unsupported file${invalid.length > 1 ? 's' : ''}: ${invalid.map(f => f.name).join(', ')}`);
    return;
  }

  processFileList(files);
}

async function processFileList(fileList) {
  outputContainer.replaceChildren();
  outputContainer.style.display = 'flex';

  const pendingCards = fileList.map(file => {
    const card = buildPendingCard(file.name);
    outputContainer.appendChild(card);
    return card;
  });

  // Focus before and after: first announces "Processing…" on focus (VoiceOver/Safari ignores aria-live on display:none containers);
  // second announces the final result label once processing completes.
  outputContainer.setAttribute('aria-label', `Processing ${fileList.length} file${fileList.length !== 1 ? 's' : ''}…`);
  outputContainer.focus();

  const results = await Promise.all(
    fileList.map((file, i) => processFile(file, pendingCards[i]))
  );

  const errorCount = results.filter(Boolean).length;
  const label = errorCount === 0
    ? `Results: all ${fileList.length} file${fileList.length > 1 ? 's' : ''} passed with no errors`
    : `Results: ${errorCount} of ${fileList.length} file${fileList.length > 1 ? 's' : ''} have errors`;
  outputContainer.setAttribute('aria-label', label);

  const clearBtn = document.createElement('button');
  clearBtn.type = 'button';
  clearBtn.className = 'btn btn-secondary checker-clear-btn';
  clearBtn.textContent = 'Clear results';
  clearBtn.addEventListener('click', () => {
    outputContainer.replaceChildren();
    outputContainer.style.display = 'none';
    outputContainer.setAttribute('aria-label', 'Results');
  });
  outputContainer.appendChild(clearBtn);

  outputContainer.focus();
}

const ROW_SAMPLE_LIMIT = 1000;

// Excel's "Unicode Text" export (and some other tools) writes UTF-16 with a BOM, not UTF-8. The
// backend only reads files as UTF-8
// We decode it well enough to still report useful column/row
// diagnostics, but always flag it as an error since the actual ingest pipeline can't read it.
function detectUtf16Encoding(buffer) {
  const bytes = new Uint8Array(buffer.slice(0, 2));
  if (bytes[0] === 0xff && bytes[1] === 0xfe) return 'utf-16le';
  if (bytes[0] === 0xfe && bytes[1] === 0xff) return 'utf-16be';
  return null;
}

async function processFile(file, pendingCard) {
  try {
    const buffer = await file.arrayBuffer();
    const encodingErrors = [];
    let text;
    const utf16Encoding = detectUtf16Encoding(buffer);
    if (utf16Encoding) {
      text = new TextDecoder(utf16Encoding).decode(buffer);
      const headerLine = text.split(/\r\n|\r|\n/)[0].split('\t').join(', ');
      const encodingName = utf16Encoding === 'utf-16le' ? 'UTF-16LE' : 'UTF-16BE';
      encodingErrors.push(`File appears to be ${encodingName} encoded - HathiTrust's ingest system only accepts UTF-8. Please re-save or re-export this file as UTF-8. (Decoded correctly, the header reads: "${headerLine}" - reading these same bytes as UTF-8 instead is what makes column names appear unrecognizable.)`);
    } else {
      // fatal: true throws on bad bytes; fall back to lenient decode so validation still runs.
      try {
        text = new TextDecoder('utf-8', { fatal: true }).decode(buffer);
      } catch {
        // Lenient decode replaces each invalid byte sequence with U+FFFD, so the first one marks
        // where the bad bytes are - show a snippet around it instead of just a blanket message.
        const lenientText = new TextDecoder('utf-8').decode(buffer);
        const badIdx = lenientText.indexOf('�');
        if (badIdx === -1) {
          encodingErrors.push('File does not appear to be UTF-8 encoded - some characters may be misread');
        } else {
          const lineNum = lenientText.slice(0, badIdx).split(/\r\n|\r|\n/).length;
          const snippet = lenientText.slice(Math.max(0, badIdx - 20), badIdx + 20).replace(/[\r\n\t]/g, ' ');
          encodingErrors.push(`File does not appear to be UTF-8 encoded - some characters may be misread (e.g. near line ${lineNum}: "...${snippet}...")`);
        }
        text = lenientText;
      }
    }
    const lines = text.split(/\r\n|\r|\n/);
    if (lines.at(-1) === '') lines.pop();
    const totalLines = lines.length;
    const firstLine = lines.shift();
    if (firstLine === undefined) {
      pendingCard.replaceWith(buildCard({ fileName: file.name, displayType: '-', columns: [], totalLines: 0, rowsChecked: 0, sampled: false, errors: encodingErrors }));
      addHistoryEntry(file.name, encodingErrors.length);
      return encodingErrors.length > 0;
    }
    const sampled = lines.length > ROW_SAMPLE_LIMIT;
    const dataRows = lines.slice(0, ROW_SAMPLE_LIMIT);
    const memberIds = await memberIdsPromise;
    return report({ file, firstLine, totalLines, dataRows, sampled, pendingCard, memberIds, encodingErrors });
  } catch {
    pendingCard.replaceWith(buildCard({ fileName: file.name, displayType: '-', columns: [], totalLines: 0, rowsChecked: 0, sampled: false, errors: ['Could not read file'] }));
    addHistoryEntry(file.name, 1);
    return true;
  }
}

function report({ file, firstLine, totalLines, dataRows, sampled, pendingCard, memberIds, encodingErrors }) {
  const columns = firstLine.split('\t');
  const { type, errors: headerErrors } = validateFile(file.name, columns, memberIds);
  const rowErrors = validateRows(columns, dataRows);
  const errors = [...encodingErrors, ...headerErrors, ...rowErrors];
  const displayType = (type in allowedTypes) ? type : '-';
  const card = buildCard({ fileName: file.name, displayType, columns, totalLines, rowsChecked: dataRows.length, sampled, errors });
  pendingCard.replaceWith(card);
  addHistoryEntry(file.name, errors.length);
  return errors.length > 0;
}
