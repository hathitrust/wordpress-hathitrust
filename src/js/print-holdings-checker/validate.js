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

export function validateFile(fileName, columns, memberIds = null) {
  const errors = [];
  const type = validateFilename(fileName, errors, memberIds);
  if (type !== null) {
    errors.push(...checkFields(type, columns));
  }
  return { type, errors };
}

function validateFilename(fileName, errors, memberIds) {
  const lowerName = fileName.toLowerCase();
  if (!lowerName.endsWith('.tsv')) {
    errors.push(`File extension must be .tsv`);
  }

  const baseName = lowerName.endsWith('.tsv') ? fileName.slice(0, -4) : fileName;
  const parts = baseName.split('_');

  // Locate the date by shape (8 digits, YYYYMMDD) so an optional _rest suffix after it is tolerated.
  const dateIdx = parts.findIndex(p => /^\d{8}$/.test(p));

  if (dateIdx === -1) {
    errors.push(`Filename must include a date in YYYYMMDD format`);
    return null;
  }

  if (dateIdx < 3) {
    errors.push(`Filename must follow the format: <member_id>_<type>_<update_type>_<date>.tsv`);
    return null;
  }

  const memberId = parts.slice(0, dateIdx - 2).join('_');
  const type = parts[dateIdx - 2];
  const updateType = parts[dateIdx - 1];
  const date = parts[dateIdx];

  if (memberIds !== null && !memberIds.has(memberId)) {
    errors.push(`'${memberId}' is not a recognized HathiTrust member ID`);
  }

  if (!(type in allowedTypes)) {
    errors.push(`'${type}' is not a recognized holdings type (must be one of mix, mon, mpm, ser, spm)`);
  }

  if (updateType !== 'full') {
    errors.push(`Update type must be 'full' (got '${updateType}')`);
  }

  if (!isValidCalendarDate(date)) {
    errors.push(`'${date}' is not a valid calendar date - date must be in YYYYMMDD format`);
  }

  return (type in allowedTypes) ? type : null;
}

function isValidCalendarDate(dateStr) {
  const year = parseInt(dateStr.slice(0, 4), 10);
  const month = parseInt(dateStr.slice(4, 6), 10);
  const day = parseInt(dateStr.slice(6, 8), 10);
  const d = new Date(year, month - 1, day);
  // JS normalizes overflowed dates (Feb 30 -> Mar 2), so if any component changed, the original was invalid.
  return d.getFullYear() === year && d.getMonth() === month - 1 && d.getDate() === day;
}

export function validateRows(columns, dataRows) {
  const errors = [];

  const oclcIdx = columns.indexOf('oclc');
  const statusIdx = columns.indexOf('status');
  const conditionIdx = columns.indexOf('condition');
  const govdocIdx = columns.indexOf('govdoc');

  const emptyLines = [];
  const nonTabLines = [];
  const wrongColumnCount = [];
  const scientificNotation = [];
  const almaMmsIds = [];
  const invalidOcns = [];
  const invalidStatus = [];
  const invalidCondition = [];
  const invalidGovdoc = [];

  const VALID_STATUS = new Set(['CH', 'LM', 'WD', '']);
  const VALID_CONDITION = new Set(['BRT', '']);
  const VALID_GOVDOC = new Set(['0', '1', '']);

  for (let i = 0; i < dataRows.length; i++) {
    const row = dataRows[i];
    const lineNum = i + 2; // 1-based, skipping header

    if (row === '') {
      emptyLines.push(lineNum);
      continue;
    }

    if (!row.includes('\t') && row.includes(',')) {
      nonTabLines.push(lineNum);
      continue;
    }

    const fields = row.split('\t');

    if (fields.length !== columns.length) {
      wrongColumnCount.push(lineNum);
    }

    if (oclcIdx >= 0 && oclcIdx < fields.length) {
      const ocnField = fields[oclcIdx].trim();
      if (ocnField !== '') {
        for (const part of ocnField.split(/[,:;|/ ]+/).map(s => s.trim()).filter(Boolean)) {
          if (/\d+\.?\d*[eE][+\-]?\d+/.test(part)) {
            scientificNotation.push(part);
          } else {
            const numeric = stripOcnPrefix(part);
            if (numeric === null || !/^\d+$/.test(numeric) || numeric === '0') {
              invalidOcns.push(part);
            } else if (/^99/.test(numeric) && numeric.length > 15) {
              almaMmsIds.push(numeric);
            }
          }
        }
      }
    }

    if (statusIdx >= 0 && statusIdx < fields.length) {
      const val = fields[statusIdx].trim();
      if (!VALID_STATUS.has(val)) invalidStatus.push(val);
    }

    if (conditionIdx >= 0 && conditionIdx < fields.length) {
      const val = fields[conditionIdx].trim();
      if (!VALID_CONDITION.has(val)) invalidCondition.push(val);
    }

    if (govdocIdx >= 0 && govdocIdx < fields.length) {
      const val = fields[govdocIdx].trim();
      if (!VALID_GOVDOC.has(val)) invalidGovdoc.push(val);
    }
  }

  if (emptyLines.length > 0)
    errors.push(linesSummary('empty line', 'empty lines', emptyLines));
  if (nonTabLines.length > 0)
    errors.push(linesSummary('row uses comma separators instead of tabs - re-export as tab-separated (.tsv)', 'rows use comma separators instead of tabs - re-export as tab-separated (.tsv)', nonTabLines));
  if (wrongColumnCount.length > 0)
    errors.push(linesSummary('row with wrong column count', 'rows with wrong column count', wrongColumnCount));
  if (scientificNotation.length > 0)
    errors.push(`${scientificNotation.length} OCN${scientificNotation.length !== 1 ? 's' : ''} in scientific notation (e.g. ${examples(scientificNotation)}) - likely reformatted by Excel`);
  if (almaMmsIds.length > 0)
    errors.push(`${almaMmsIds.length} apparent Alma MMS ID${almaMmsIds.length !== 1 ? 's' : ''} in oclc column (e.g. ${examples(almaMmsIds)}) - replace with OCLC numbers`);
  if (invalidOcns.length > 0)
    errors.push(`${invalidOcns.length} invalid OCN${invalidOcns.length !== 1 ? 's' : ''} - must be digits or a prefixed number like ocn12345 or (OCoLC)12345 (e.g. ${examples(invalidOcns)})`);
  if (invalidStatus.length > 0)
    errors.push(`${invalidStatus.length} invalid status value${invalidStatus.length !== 1 ? 's' : ''} - must be CH, LM, WD, or empty (got ${examples(invalidStatus)})`);
  if (invalidCondition.length > 0)
    errors.push(`${invalidCondition.length} invalid condition value${invalidCondition.length !== 1 ? 's' : ''} - must be BRT or empty (got ${examples(invalidCondition)})`);
  if (invalidGovdoc.length > 0)
    errors.push(`${invalidGovdoc.length} invalid govdoc value${invalidGovdoc.length !== 1 ? 's' : ''} - must be 0, 1, or empty (got ${examples(invalidGovdoc)})`);

  return errors;
}

function linesSummary(singular, plural, lineNums) {
  const isPlural = lineNums.length !== 1;
  const shown = lineNums.slice(0, 5).join(', ') + (lineNums.length > 5 ? '…' : '');
  return `${lineNums.length} ${isPlural ? plural : singular} (line${isPlural ? 's' : ''}: ${shown})`;
}

// Strips known OCN prefixes ((OCoLC), ocm, ocn, etc.) and returns the numeric string.
// Handles nested prefixes like (OCoLC)ocm12345. Returns null for unrecognized paren prefixes.
function stripOcnPrefix(val) {
  let result = val;
  if (/^\((oclc|ocm|ocn|ocolc|on)\)/i.test(result)) {
    result = result.replace(/^\(.+?\)/, '');
  } else if (/^\(.+?\)/.test(result)) {
    return null;
  }
  if (/^(oclc|ocm|ocn|ocolc|on)/i.test(result)) {
    result = result.replace(/^\D+/, '');
  }
  return result;
}

function examples(values) {
  return [...new Set(values)].slice(0, 3).map(v => `'${v}'`).join(', ');
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
