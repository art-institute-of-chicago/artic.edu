/**
 *
 * Rename files using a content hash
 * Works for a given file, or all files in a given directory
 *
 */
require('dotenv').config();

const fs = require('fs');
const path = require('path');
const crypto = require('crypto');
const useContentHash = process.env.NODE_ENV === 'production' || process.env.USE_COMPILED_REVASSETS === 'true';

// Exit early if content hash is not required
if (!useContentHash) {
  process.exit(0);
}

// Ensure an argument is provided
if (process.argv.length < 3) {
  console.error('Please provide a directory to hash files in');
  process.exit(1);
}

// Use positional argument as the path to hash files
hashFiles(process.argv[2]);


/**
 * getHash
 *
 * @param {*} content The contents of the file to hash
 * @returns {string} The hash of the file content
 */
function getHash (content) {
  return crypto
    .createHash('md5')
    .update(content)
    .digest('hex')
    .slice(0, 16); // Trimmed for terseness
}


/**
 * hashFile
 * Hash a single file
 *
 * @param {*} filePath Path to the file to hash
 * @returns {void}
 */
function hashFile (filePath) {
  try {
    const content = fs.readFileSync(filePath, 'utf8');
    const hash = getHash(content);
    const extension = filePath.split('.').pop();
    const hashFileName = `${filePath.replace(`.${extension}`, '')}-${hash}.${extension}`;
    fs.renameSync(filePath, hashFileName);
  }
  catch (err) {
    console.error(`Failed to hash file ${filePath}:`, err);
  }
}

/**
 * hashFiles
 * Will either hash a single file or all files in a directory
 *
 * @fires hashFile
 * @param {string} inputPath Path to the file or directory to hash
 * @returns {void}
 */
function hashFiles (inputPath) {
  try {
    const stat = fs.statSync(inputPath);

    // (Attempt to) Hash a single file if it's not a directory
    if (!stat.isDirectory()) {
      hashFile(inputPath);
      return;
    }

    // Otherwise hash all files in the directory
    const files = fs.readdirSync(inputPath);
    files.forEach((file) => {
      const filePath = path.resolve(inputPath, file);
      const stat = fs.statSync(filePath);
      if (stat.isDirectory()) {
        hashFiles(filePath);
      } else {
        hashFile(filePath);
      }
    });
  }
  catch (err) {
    console.error(`Failed to hash files in ${inputPath}:`, err);
  }
}
