import { validateFile, allowedTypes } from './validate.js';
import { buildCard, buildPendingCard, showError } from './ui.js';

const outputContainer = document.getElementById('output');
const dropZone = document.getElementById('drop-zone');

if (dropZone) {
  dropZone.addEventListener('drop', dropHandler);
  dropZone.addEventListener('dragover', dragOverHandler);
  dropZone.addEventListener('dragenter', dragEnterHandler);
  dropZone.addEventListener('dragleave', dragLeaveHandler);

  const fileInput = document.getElementById('file-input');
  document.getElementById('file-button').addEventListener('click', () => fileInput.click());
  fileInput.addEventListener('change', (event) => {
    const files = [...event.target.files];
    const invalid = files.filter(f => !f.name.endsWith('.tsv'));
    if (invalid.length > 0) {
      showError(outputContainer, `Only .tsv files are supported. Unsupported file${invalid.length > 1 ? 's' : ''}: ${invalid.map(f => f.name).join(', ')}`);
      return;
    }
    processFileList(files);
  });
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
  const invalid = files.filter(f => !f.name.endsWith('.tsv'));
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

  const results = await Promise.all(
    fileList.map((file, i) => processFile(file, pendingCards[i]))
  );

  const errorCount = results.filter(Boolean).length;
  const label = errorCount === 0
    ? `Results: all ${fileList.length} file${fileList.length > 1 ? 's' : ''} passed`
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

async function processFile(file, pendingCard) {
  try {
    const text = await file.text();
    const lines = text.split(/\r\n|\r|\n/);
    if (lines.at(-1) === '') lines.pop();
    const totalLines = lines.length;
    const firstLine = lines.shift();
    if (firstLine === undefined) {
      pendingCard.replaceWith(buildCard({ fileName: file.name, displayType: '—', columns: [], totalLines: 0, errors: [] }));
      return false;
    }
    return report(file, firstLine, totalLines, pendingCard);
  } catch {
    pendingCard.replaceWith(buildCard({ fileName: file.name, displayType: '—', columns: [], totalLines: 0, errors: ['Could not read file'] }));
    return true;
  }
}

function report(file, firstLine, totalLines, pendingCard) {
  const columns = firstLine.split('\t');
  const { type, errors } = validateFile(file.name, columns);
  const displayType = (type in allowedTypes) ? type : '—';
  const card = buildCard({ fileName: file.name, displayType, columns, totalLines, errors });
  pendingCard.replaceWith(card);
  return errors.length > 0;
}
