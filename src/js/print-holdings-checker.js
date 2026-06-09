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
      showError(`Only .tsv files are supported. Unsupported file${invalid.length > 1 ? 's' : ''}: ${invalid.map(f => f.name).join(', ')}`);
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
        showError('Folders cannot be dropped here. Please select individual .tsv files.');
        return;
      }
    }
  }

  const files = [...event.dataTransfer.files];
  const invalid = files.filter(f => !f.name.endsWith('.tsv'));
  if (invalid.length > 0) {
    showError(`Only .tsv files are supported. Unsupported file${invalid.length > 1 ? 's' : ''}: ${invalid.map(f => f.name).join(', ')}`);
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

const allowedTypes = {
  spm: {
    required: ['local_id', 'oclc'],
    optional: ['status', 'condition', 'govdoc'],
    disallowed: ['enum_chron', 'issn']
  },
  mpm: {
    required: ['local_id', 'oclc', 'enum_chron'],
    optional: ['status', 'condition', 'govdoc'],
    disallowed: ['issn']
  },
  ser: {
    required: ['local_id', 'oclc'],
    optional: ['issn', 'govdoc'],
    disallowed: ['status', 'condition', 'enum_chron']
  },
  mon: {
    required: ['local_id', 'oclc'],
    optional: ['status', 'condition', 'enum_chron', 'govdoc'],
    disallowed: ['issn']
  },
  mix: {
    required: ['local_id', 'oclc'],
    optional: ['govdoc'],
    disallowed: ['status', 'condition', 'enum_chron', 'issn']
  }
};

function validateFile(fileName, columns) {
  const parts = fileName.split('_');
  const type = parts[1];
  const errors = [];

  if (parts.length < 4) {
    errors.push(`Filename must follow the format: <member_id>_<type>_<update_type>_<date>.tsv`);
  } else if (!(type in allowedTypes)) {
    errors.push(`'${type}' is not a recognized holdings type (should be one of mix, mon, mpm, ser, spm)`);
  } else {
    errors.push(...checkFields(type, columns));
  }

  return { type, errors };
}

function buildCard({ fileName, type, columns, totalLines, errors }) {
  const hasErrors = errors.length > 0;

  const card = document.createElement('article');
  card.className = `file-card ${hasErrors ? 'file-card--error' : 'file-card--ok'}`;
  const statusLabel = hasErrors
    ? `${errors.length} error${errors.length > 1 ? 's' : ''} found`
    : 'No errors';
  card.setAttribute('aria-label', `${fileName}, ${statusLabel}`);

  const header = document.createElement('div');
  header.className = 'file-card-header';
  const fileNameHeading = document.createElement('h2');
  fileNameHeading.className = 'file-card-name h3';
  fileNameHeading.textContent = fileName;
  const badge = document.createElement('span');
  badge.className = 'file-card-badge';
  badge.textContent = hasErrors ? 'Errors' : 'No Errors';
  header.appendChild(fileNameHeading);
  header.appendChild(badge);
  card.appendChild(header);

  const meta = document.createElement('dl');
  meta.className = 'file-card-meta';
  const metaFields = [
    ['Type', (type in allowedTypes) ? type : '—'],
    ['Total lines', totalLines],
    ['Columns', columns.join(', ')],
  ];
  for (const [label, value] of metaFields) {
    const div = document.createElement('div');
    const dt = document.createElement('dt');
    dt.textContent = label;
    const dd = document.createElement('dd');
    dd.textContent = value;
    div.appendChild(dt);
    div.appendChild(dd);
    meta.appendChild(div);
  }
  card.appendChild(meta);

  if (hasErrors) {
    const ul = document.createElement('ul');
    ul.className = 'file-card-errors';
    ul.setAttribute('aria-label', 'Errors');
    for (const error of errors) {
      const li = document.createElement('li');
      li.textContent = error;
      ul.appendChild(li);
    }
    card.appendChild(ul);
  }

  return card;
}

function showError(message) {
  outputContainer.replaceChildren();
  outputContainer.style.display = 'flex';
  outputContainer.setAttribute('aria-label', 'Error');
  const alertEl = document.createElement('p');
  alertEl.className = 'checker-drop-error';
  alertEl.setAttribute('role', 'alert');
  alertEl.textContent = message;
  outputContainer.appendChild(alertEl);
  outputContainer.focus();
}

function report(file, firstLine, totalLines) {
  const columns = firstLine.split('\t');
  const { type, errors } = validateFile(file.name, columns);
  const card = buildCard({ fileName: file.name, type, columns, totalLines, errors });
  outputContainer.appendChild(card);
  return errors.length > 0;
}

// Returns a possibly empty array of errors
function checkFields(type, columns) {
  const errors = [];
  const requiredColumns = allowedTypes[type].required;
  const optionalColumns = allowedTypes[type].optional;
  const disallowedColumns = allowedTypes[type].disallowed;
  for (const column of columns) {
    if (requiredColumns.includes(column) || optionalColumns.includes(column)) {
      continue;
    } else if (disallowedColumns.includes(column)) {
      errors.push(`Column '${column}' is not allowed in a '${type}' file`);
    } else if (column === 'gov_doc') {
      errors.push(`Column '${column}' should be named 'govdoc'`);
    } else if (column === 'localid') {
      errors.push(`Column '${column}' should be named 'local_id'`);
    } else if (column === 'enumchron') {
      errors.push(`Column '${column}' should be named 'enum_chron'`);
    } else {
      errors.push(`Unknown column '${column}'`);
    }
  }
  // Make sure all required columns are there
  for (const column of requiredColumns) {
    if (!columns.includes(column)) {
      errors.push(`Required field '${column}' is missing`);
    }
  }
  return errors;
}
