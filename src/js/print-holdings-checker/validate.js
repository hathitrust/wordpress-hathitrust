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
