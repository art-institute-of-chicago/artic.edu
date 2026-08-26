const percySnapshot = require('@percy/playwright');
const { genericPageSlug } = require('../fixtures');
const { HOURS_WIDGET_CSS } = require('../percyCSS');

module.exports = async function snapshotGenericPage(page, baseUrl) {
  await page.goto(`${baseUrl}/${genericPageSlug}`);
  await page.waitForSelector('article.o-article--generic-page');
  await percySnapshot(page, 'Generic CMS page', { percyCSS: HOURS_WIDGET_CSS });
};
