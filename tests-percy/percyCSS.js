// Shared CSS masks for elements that are inherently dynamic (change by time
// of day, day of week, etc.) and would otherwise produce visual diffs
// unrelated to real code changes.
const HOURS_WIDGET_CSS = '.o-hours { visibility: hidden !important; }';

const COLLECTION_LISTING_CSS = `
  ${HOURS_WIDGET_CSS}
  .m-search-actions li:last-child { visibility: hidden !important; }
`;

module.exports = { HOURS_WIDGET_CSS, COLLECTION_LISTING_CSS };
