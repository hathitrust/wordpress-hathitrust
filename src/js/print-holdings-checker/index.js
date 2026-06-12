import { validateFile } from './validate.js';
import { buildCard, showError } from './ui.js';

const outputContainer = document.getElementById('output');

addEventListener('load', () => {
  const dropZone = document.getElementById('drop-zone');
  if (!dropZone) return;
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
});

function dragOverHandler(event) {
  event.preventDefault();
}

function dragEnterHandler(event) {
  event.preventDefault();
  this.classList.add('drag-over');
}

function dragLeaveHandler(event) {
  event.preventDefault();
  this.classList.remove('drag-over');
}

function dropHandler(event) {
  event.preventDefault();
  this.classList.remove('drag-over');

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

function processFileList(fileList) {
  outputContainer.replaceChildren();
  outputContainer.style.display = 'flex';
  let remaining = fileList.length;
  let errorCount = 0;
  fileList.forEach(file => processFile(file, (hasErrors) => {
    if (hasErrors) errorCount++;
    remaining--;
    if (remaining === 0) {
      const label = errorCount === 0
        ? `Results: all ${fileList.length} file${fileList.length > 1 ? 's' : ''} passed`
        : `Results: ${errorCount} of ${fileList.length} file${fileList.length > 1 ? 's' : ''} have errors`;
      outputContainer.setAttribute('aria-label', label);
      outputContainer.focus();
    }
  }));
}

function processFile(file, onComplete) {
  const reader = new FileReader();
  reader.onload = () => {
    const text = reader.result;
    const lines = text.split(/\r\n|\r|\n/);
    if (lines.at(-1) === '') lines.pop();
    const totalLines = lines.length;
    const firstLine = lines.shift();
    const hasErrors = firstLine !== undefined ? report(file, firstLine, totalLines) : false;
    onComplete(hasErrors);
  };
  reader.onerror = () => onComplete(false);
  reader.readAsText(file, 'UTF-8');
}

function report(file, firstLine, totalLines) {
  const columns = firstLine.split('\t');
  const { type, errors } = validateFile(file.name, columns);
  const card = buildCard({ fileName: file.name, type, columns, totalLines, errors });
  outputContainer.appendChild(card);
  return errors.length > 0;
}
