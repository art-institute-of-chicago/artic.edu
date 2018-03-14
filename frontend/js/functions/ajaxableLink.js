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

  ajaxableHref(href);

  // don't fire if no href or same page
  if (!href || href.indexOf('#') > 0 || href === location.href) {
    //return false;
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
  // don't fire if external or not same protocol
  if (window.location.protocol !== el.protocol || window.location.hostname !== el.hostname) {
    //return false;
  }
  // passed?
  return { href: href, el: el };
};

export default ajaxableLink;
