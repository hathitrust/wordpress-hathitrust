export const allowedTypes = {
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

export function validateFile(fileName, columns) {
  const errors = [];
  const type = validateFilename(fileName, errors);
  if (type !== null) {
    errors.push(...checkFields(type, columns));
  }
  return { type, errors };
}

function validateFilename(fileName, errors) {
  if (!fileName.endsWith('.tsv')) {
    errors.push(`File extension must be .tsv`);
  }

  const baseName = fileName.endsWith('.tsv') ? fileName.slice(0, -4) : fileName;
  const parts = baseName.split('_');

  if (parts.length < 4) {
    errors.push(`Filename must follow the format: <member_id>_<type>_<update_type>_<date>.tsv`);
    return null;
  }

  const type = parts.at(-3);
  const updateType = parts.at(-2);
  const date = parts.at(-1);

  if (!(type in allowedTypes)) {
    errors.push(`'${type}' is not a recognized holdings type (should be one of mix, mon, mpm, ser, spm)`);
  }

  if (updateType !== 'full') {
    errors.push(`Update type must be 'full' (got '${updateType}')`);
  }

  if (!/^\d{8}$/.test(date)) {
    errors.push(`Date must be 8 digits in YYYYMMDD format (got '${date}')`);
  } else if (!isValidCalendarDate(date)) {
    errors.push(`'${date}' is not a valid calendar date`);
  }

  return (type in allowedTypes) ? type : null;
}

function isValidCalendarDate(dateStr) {
  const year = parseInt(dateStr.slice(0, 4), 10);
  const month = parseInt(dateStr.slice(4, 6), 10);
  const day = parseInt(dateStr.slice(6, 8), 10);
  const d = new Date(year, month - 1, day);
  return d.getFullYear() === year && d.getMonth() === month - 1 && d.getDate() === day;
}

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
  for (const column of requiredColumns) {
    if (!columns.includes(column)) {
      errors.push(`Required field '${column}' is missing`);
    }
  }
  return errors;
}
