const { chromium } = require('playwright');

const snapshots = [
  require('./pages/home'),
  require('./pages/artwork'),
  require('./pages/collection'),
  require('./pages/genericPage'),
];

// No default: local dev domains vary per developer's aic-docker setup
// (e.g. http://www.test vs http://www-dev.artic.edu), and CI always sets
// this explicitly (see .github/workflows/percy.yml) — silently falling
// back to a guess risks snapshotting the wrong app or timing out.
const BASE_URL = process.env.BASE_URL;
if (!BASE_URL) {
  throw new Error('BASE_URL environment variable is required, e.g. BASE_URL=http://www-dev.artic.edu npm run test:percy');
}

(async () => {
  const browser = await chromium.launch();
  const page = await browser.newPage();

  try {
    for (const snapshot of snapshots) {
      await snapshot(page, BASE_URL);
    }
  } finally {
    await browser.close();
  }
})();
