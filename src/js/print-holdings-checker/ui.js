export function buildPendingCard(fileName) {
  const card = document.createElement('article');
  card.className = 'file-card file-card--pending';
  card.setAttribute('aria-label', `${fileName}, processing`);
  card.setAttribute('aria-busy', 'true');

  const header = document.createElement('div');
  header.className = 'file-card-header';
  const fileNameHeading = document.createElement('h2');
  fileNameHeading.className = 'file-card-name h3';
  fileNameHeading.textContent = fileName;
  const spinner = document.createElement('span');
  spinner.className = 'file-card-spinner';
  spinner.setAttribute('aria-hidden', 'true');
  header.appendChild(fileNameHeading);
  header.appendChild(spinner);
  card.appendChild(header);

  return card;
}

export function buildCard({ fileName, displayType, columns, totalLines, errors }) {
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
    ['Type', displayType],
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

export function showError(outputContainer, message) {
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
