import { ajaxableHref } from '../core';

const ajaxableLink = function(link, event) {
  if (!link || !event) {
    return false;
  }

  var el = link;
  var href = el.href;

  // Is this click from a link
  if (link.tagName !== 'A') {
    return false;
  }

  // Check if the href is ajaxable
  if (!ajaxableHref(href, event)) {
    return false;
  }
  // Don't fire if its got a no ajax attribute or a download attribute
  if (el.hasAttribute('data-no-ajax') || el.hasAttribute('download')) {
    return false;
  }
  // Don't fire for external links
  if (el.target && el.target !== '_blank') {
    return false;
  }
  // Don't fire if probably trying to open in a new window
  if (event.which > 1 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
    return false;
  }
  // Passed?
  return { href: href, el: el };
};

export default ajaxableLink;
