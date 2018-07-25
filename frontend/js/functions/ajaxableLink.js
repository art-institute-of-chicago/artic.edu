import { ajaxableHref } from '../functions';

const ajaxableLink = function(link, event) {
  if (!link || !event) {
    return false;
  }

  var el = link;
  var href = el.href;

  // is this click from a link
  if (link.tagName !== 'A') {
    return false;
  }

  // check if the href is ajaxable
  if (!ajaxableHref(href, event)) {
    return false;
  }
  // don't fire if its got a no ajax attribute or a download attribute
  if (el.hasAttribute('data-no-ajax') || el.hasAttribute('download')) {
    return false;
  }
  // don't fire for external links
  if (el.target && el.target !== '_blank') {
    return false;
  }
  // don't fire if probably trying to open in a new window
  if (event.which > 1 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
    return false;
  }
  // passed?
  return { href: href, el: el };
};

export default ajaxableLink;
