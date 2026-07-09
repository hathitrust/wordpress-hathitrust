// Common nonstandard spellings that still clearly indicate an intended type.
const TYPE_ALIASES = {
  monograph: 'mon',
  monographs: 'mon',
  serial: 'ser',
  serials: 'ser',
  multipart: 'mpm',
  'multi-part': 'mpm',
  multi_part: 'mpm',
  mixed: 'mix'
};

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

const COMMON_REQUIRED_COLUMNS = ['local_id', 'oclc'];

export function validateFile(fileName, columns, memberIds = null) {
  const errors = [];
  const type = validateFilename(fileName, errors, memberIds);
  if (type !== null) {
    errors.push(...checkFields(type, columns));
  } else {
    // Holdings type is unknown, so the full required/optional/disallowed set is unknown too
    // but every type requires these columns, so check for them regardless.
    const normalizedColumns = columns.map(normalizeColumn);
    for (const column of COMMON_REQUIRED_COLUMNS) {
      if (!normalizedColumns.includes(column)) {
        errors.push(`Required field '${column}' is missing`);
      }
    }
  }
  return { type, errors };
}

function validateFilename(fileName, errors, memberIds) {
  const lowerName = fileName.toLowerCase();
  if (!lowerName.endsWith('.tsv')) {
    errors.push(`Filename: file extension must be .tsv`);
  }

  const baseName = lowerName.endsWith('.tsv') ? fileName.slice(0, -4) : fileName;
  const parts = baseName.split('_');

  // Locate the date by shape (8 digits). Prefer an exact match, but fall back to a near miss -
  // a segment starting with 8 digits but with trailing text glued on (e.g. ".tsv.tsv").
  const dateIdx = parts.findIndex(p => /^\d{8}$/.test(p));
  const effectiveIdx = dateIdx !== -1 ? dateIdx : parts.findIndex(p => /^\d{8}/.test(p));

  // With a usable date position and enough segments before it, extract fields by their normal
  // position. Otherwise a whole segment (usually update_type) is likely missing, which shifts
  // everything - pull the date out by shape wherever it landed instead of assuming it's missing,
  // and assign whatever segments remain to member_id/type/update_type in order.
  let memberId, type, updateType, dateSegment;
  if (effectiveIdx !== -1 && effectiveIdx >= 3) {
    memberId = parts.slice(0, effectiveIdx - 2).join('_');
    type = parts[effectiveIdx - 2];
    updateType = parts[effectiveIdx - 1];
    dateSegment = parts[effectiveIdx];
  } else if (effectiveIdx !== -1) {
    dateSegment = parts[effectiveIdx];
    [memberId, type, updateType] = parts.slice(0, effectiveIdx).concat(parts.slice(effectiveIdx + 1));
  } else {
    [memberId, type, updateType, dateSegment] = parts;
  }

  return validateFilenameFields({ memberId, type, updateType, dateSegment }, errors, memberIds);
}

// Reports each filename field independently rather than one all-or-nothing message, mirroring
// the backend's own diagnostic
function validateFilenameFields({ memberId, type, updateType, dateSegment }, errors, memberIds) {
  if (!memberId) {
    errors.push(`Filename: member ID is missing`);
  } else if (memberIds !== null && !memberIds.has(memberId)) {
    errors.push(`Filename: '${memberId}' is not a recognized HathiTrust member ID`);
  }

  let resolvedType = null;
  if (!type) {
    errors.push(`Filename: holdings type is missing`);
  } else if (type in allowedTypes) {
    resolvedType = type;
  } else {
    const alias = TYPE_ALIASES[type.toLowerCase()];
    if (alias) {
      errors.push(`Filename: '${type}' is not a recognized holdings type - assuming you meant '${alias}' (must be one of mix, mon, mpm, ser, spm)`);
      resolvedType = alias;
    } else {
      errors.push(`Filename: '${type}' is not a recognized holdings type (must be one of mix, mon, mpm, ser, spm)`);
    }
  }

  if (!updateType) {
    errors.push(`Filename: update type is missing`);
  } else if (updateType !== 'full') {
    errors.push(`Filename: update type must be 'full' (got '${updateType}')`);
  }

  if (!dateSegment) {
    errors.push(`Filename: date is missing`);
  } else if (/^\d{8}$/.test(dateSegment)) {
    if (!isValidCalendarDate(dateSegment)) {
      errors.push(`Filename: '${dateSegment}' is not a valid calendar date - date must be in YYYYMMDD format`);
    }
  } else if (/^\d{8}/.test(dateSegment)) {
    errors.push(`Filename: '${dateSegment}' contains the date ${dateSegment.slice(0, 8)}, but is followed by unexpected text '${dateSegment.slice(8)}' - only an underscore-separated suffix or the .tsv extension may follow the date`);
  } else {
    errors.push(`Filename: '${dateSegment}' is not a valid date in YYYYMMDD format`);
  }

  return resolvedType;
}

function isValidCalendarDate(dateStr) {
  const year = parseInt(dateStr.slice(0, 4), 10);
  const month = parseInt(dateStr.slice(4, 6), 10);
  const day = parseInt(dateStr.slice(6, 8), 10);
  const d = new Date(year, month - 1, day);
  // JS normalizes overflowed dates (Feb 30 -> Mar 2), so if any component changed, the original was invalid.
  return d.getFullYear() === year && d.getMonth() === month - 1 && d.getDate() === day;
}

// Matches the backend's Scrub::Issn / Scrub::Common constants
const ISSN = /^\d{4}-?\d{3}[0-9Xx]$/;
const ISSN_DELIM = /[,; ]+/;

// Matches the backend's Scrub::LocalId / Scrub::Common constants
const LOCAL_ID_MAX_LEN = 50;
const LOCAL_ID_DELIM = /[,; ]+/;

export function validateRows(columns, dataRows) {
  const errors = [];

  // Matches checkFields()'s header matching - a header like "OCLC" or " status" must resolve to
  // the same column here, or its values silently skip validation entirely.
  const normalizedColumns = columns.map(normalizeColumn);
  const oclcIdx = normalizedColumns.indexOf('oclc');
  const statusIdx = normalizedColumns.indexOf('status');
  const conditionIdx = normalizedColumns.indexOf('condition');
  const govdocIdx = normalizedColumns.indexOf('govdoc');
  const issnIdx = normalizedColumns.indexOf('issn');
  const localIdIdx = normalizedColumns.indexOf('local_id');

  const emptyLines = [];
  const nonTabLines = [];
  const wrongColumnCount = [];
  const scientificNotation = [];
  const almaMmsIds = [];
  const invalidOcns = [];
  const invalidStatus = [];
  const invalidCondition = [];
  const invalidGovdoc = [];
  const invalidIssns = [];
  const overlongLocalIds = [];

  const VALID_STATUS = new Set(['CH', 'LM', 'WD', '']);
  const VALID_CONDITION = new Set(['BRT', '']);
  const VALID_GOVDOC = new Set(['0', '1', '']);

  for (let i = 0; i < dataRows.length; i++) {
    const row = dataRows[i];
    const lineNum = i + 2; // 1-based, skipping header

    if (row.split('\t').every(field => field.trim() === '')) {
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

    if (issnIdx >= 0 && issnIdx < fields.length) {
      const issnField = fields[issnIdx].trim();
      if (issnField !== '') {
        for (const candidate of issnField.split(ISSN_DELIM).map(s => s.trim()).filter(Boolean)) {
          if (!ISSN.test(candidate)) invalidIssns.push(candidate);
        }
      }
    }

    if (localIdIdx >= 0 && localIdIdx < fields.length) {
      const localIdField = fields[localIdIdx].trim();
      for (const candidate of localIdField.split(LOCAL_ID_DELIM).map(s => s.trim()).filter(Boolean)) {
        if (candidate.length > LOCAL_ID_MAX_LEN) overlongLocalIds.push(candidate);
      }
    }
  }

  if (emptyLines.length > 0)
    errors.push(linesSummary('empty line', 'empty lines', emptyLines));
  if (nonTabLines.length > 0)
    errors.push(linesSummary('row uses comma separators instead of tabs - re-export as tab-separated (.tsv)', 'rows use comma separators instead of tabs - re-export as tab-separated (.tsv)', nonTabLines));
  if (wrongColumnCount.length > 0)
    errors.push(linesSummary('row has a column count disagreement with the header line', 'rows have a column count disagreement with the header line', wrongColumnCount));
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
  if (invalidIssns.length > 0)
    errors.push(`${invalidIssns.length} invalid ISSN${invalidIssns.length !== 1 ? 's' : ''} - must match DDDD-DDDC (hyphen optional, last character may be X) (e.g. ${examples(invalidIssns)})`);
  if (overlongLocalIds.length > 0)
    errors.push(`${overlongLocalIds.length} local_id value${overlongLocalIds.length !== 1 ? 's' : ''} longer than ${LOCAL_ID_MAX_LEN} characters (e.g. ${examples(overlongLocalIds.map(id => id.length > 30 ? `${id.slice(0, 30)}…` : id))})`);

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

// Matches the backend's own header normalization so a column isn't flagged as "unknown" here when the backend
// would actually accept it.
function normalizeColumn(column) {
  return column.toLowerCase().replace(/\s+/g, '');
}

function checkFields(type, columns) {
  const errors = [];
  const requiredColumns = allowedTypes[type].required;
  const optionalColumns = allowedTypes[type].optional;
  const disallowedColumns = allowedTypes[type].disallowed;
  const normalizedColumns = columns.map(normalizeColumn);
  for (const column of columns) {
    const normalized = normalizeColumn(column);
    if (requiredColumns.includes(normalized) || optionalColumns.includes(normalized)) {
      continue;
    } else if (disallowedColumns.includes(normalized)) {
      errors.push(`Column '${column}' is not allowed in a '${type}' file`);
    } else if (normalized === 'gov_doc') {
      errors.push(`Column '${column}' should be named 'govdoc'`);
    } else if (normalized === 'localid') {
      errors.push(`Column '${column}' should be named 'local_id'`);
    } else if (normalized === 'enumchron') {
      errors.push(`Column '${column}' should be named 'enum_chron'`);
    } else {
      errors.push(`Unknown column '${column}'`);
    }
  }
  for (const column of requiredColumns) {
    if (!normalizedColumns.includes(column)) {
      errors.push(`Required field '${column}' is missing`);
    }
  }
  return errors;
}
