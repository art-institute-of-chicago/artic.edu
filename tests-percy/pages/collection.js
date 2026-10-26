const percySnapshot = require('@percy/playwright');
const { COLLECTION_LISTING_CSS } = require('../percyCSS');

// A fixed search query keeps the result grid small and stable rather than
// snapshotting the full, ever-growing unfiltered collection listing.
const SEARCH_QUERY = 'american gothic';

module.exports = async function snapshotCollection(page, baseUrl) {
  await page.goto(`${baseUrl}/collection?q=${encodeURIComponent(SEARCH_QUERY)}`);
  await page.waitForSelector('.o-collection-listing');
  await percySnapshot(page, 'Collection search', { percyCSS: COLLECTION_LISTING_CSS });
};
