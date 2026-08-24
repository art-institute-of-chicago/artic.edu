const percySnapshot = require('@percy/playwright');
const { artworkId } = require('../fixtures');
const { HOURS_WIDGET_CSS } = require('../percyCSS');

module.exports = async function snapshotArtwork(page, baseUrl) {
  await page.goto(baseUrl + '/artworks/' + artworkId);
  await page.waitForSelector('article.o-article');
  await percySnapshot(page, 'Artwork detail', { percyCSS: HOURS_WIDGET_CSS });
};
