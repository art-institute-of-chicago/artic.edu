/**
 * fetchStyleVariables.js
 * Fetches the Style Dictionary CSS variables once at build time and writes
 * them to a local Sass partial, so the browser never has to fetch them.
 *
 * Exports fetchStyleVariables function for use in webpack.config.js
 */

const fs = require('fs').promises;
const path = require('path');

const OUTPUT_PATH = path.resolve(__dirname, '../../frontend/scss/setup/_styleVariables.scss');

/**
 * fetchStyleVariables
 * Fetches the Style Dictionary CSS variables from STYLES_SERVICE_URL and
 * writes them to OUTPUT_PATH. Falls back to an empty file, with a warning,
 * if the env var is unset or the request fails.
 *
 * @returns {Promise<void>}
 */
async function fetchStyleVariables() {
  const stylesServiceUrl = process.env.STYLES_SERVICE_URL;

  if (!stylesServiceUrl) {
    console.warn('STYLES_SERVICE_URL is not set; skipping styles service variables fetch.');
    await fs.writeFile(OUTPUT_PATH, '// STYLES_SERVICE_URL was not set at build time\n');
    return;
  }

  try {
    const response = await fetch(`${stylesServiceUrl}/storage/variables.scss`);

    if (!response.ok) {
      throw new Error(`Request failed with status ${response.status}`);
    }

    const variables = await response.text();
    await fs.writeFile(OUTPUT_PATH, variables);
  } catch (err) {
    console.warn(`Failed to fetch Style Dictionary variables from ${stylesServiceUrl}: ${err.message}`);
    await fs.writeFile(OUTPUT_PATH, `// Failed to fetch Style Dictionary variables: ${err.message}\n`);
  }
}

module.exports = { fetchStyleVariables };
