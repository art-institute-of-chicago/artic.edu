const percySnapshot = require('@percy/playwright');
const { HOURS_WIDGET_CSS } = require('../percyCSS');

module.exports = async function snapshotHome(page, baseUrl) {
  await page.goto(baseUrl + '/');
  await page.waitForSelector('.o-landingpage__body');
  await percySnapshot(page, 'Home', { percyCSS: HOURS_WIDGET_CSS });
};
