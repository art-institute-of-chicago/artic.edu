/**
 * GenerateRevManifest.js
 * Creates a file that maps dist file names to their content hashed versions
 *
 * Can be run from the CLI with `node scripts/generateRevManifest.js <inputPath> <outputPath>`
 * Also exports generateRevManifest function for use in other scripts
 */

const fs = require('fs');
const path = require('path');

// JSON content for manifest file
const manifest = {};

/**
 * removeContentHash
 * Removes the content hash from a filename
 *
 * @param {string} filename Filename to remove content hash from
 * @returns {string} Filename with content hash removed
 */
function removeContentHash(filename) {
  // Match two groups: the filename and the extension
  // This omits the content hash, which we expect to be 8 or more characters long
  // Where the hash comes after a hyphen (lazy) but before the extension (greedy)
  // This should do a good enough job, but may need tuning

  const regex = /^(.*?)-[a-f0-9]{8,}\.(.*)$/;
  const match = filename.match(regex);
  if (match) {
    return `${match[1]}.${match[2]}`;
  }
  return filename;
};

/**
 * processPath
 * Crawls a path and adds file mappings to the manifest
 *
 * @param {string} incomingPath Path to crawl
 */
function processPath(incomingPath) {
  const files = fs.readdirSync(incomingPath);

  files.forEach((file) => {
    const filePath = path.join(incomingPath, file);

    // Skip the manifest
    if (filePath.includes(path.join(incomingPath, 'rev-manifest.json'))) {
      return;
    }

    const stat = fs.statSync(filePath);

    if (stat.isDirectory()) {
      // Recurse into sub-directories
      processPath(filePath);
    } else {
      // Add file to manifest
      const hashedName = path.relative(incomingPath, filePath);
      const originalName = removeContentHash(hashedName);
      manifest[originalName] = hashedName;
    }
  });
};

/**
 * generateRevManifest
 * Write the manifest file to disk
 * @param {string} inputPath Path to crawl
 * @param {string} outputPath Path to write the manifest file to
 * @returns {void}
 */

function generateRevManifest(inputPath, outputPath) {
  processPath(inputPath);
  fs.writeFileSync(outputPath, JSON.stringify(manifest, null, 2), 'utf-8');
  console.log(`Manifest generated at ${outputPath}`);
}

// Check if the script is being run on the CLI
if (require.main === module) {
  const args = process.argv.slice(2);

  // Check for the required arguments
  if (args < 2) {
    console.error('Usage: generateRevManifest.js <inputPath> <outputPath>');
    process.exit(1);
  }

  // Run using the CLI arguments
  generateRevManifest(args[0], args[1]);
}

module.exports = { generateRevManifest };
