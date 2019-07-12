const ajaxableHref = function(href, event) {
  // fail if no href
  if (!href || href === '#') {
    return false;
  }

  // fail if external or not same protocol
  var el = document.createElement('a');
  el.href = href;
  if (window.location.protocol !== el.protocol || window.location.hostname !== el.hostname) {
    // off site link
    return false;
  }

  // sometimes the target is an element within the anchor
  var target = event.target;
  if (target.tagName !== 'A') {
    if (target === document) {
      return true;
    } else {
      target = target.closest('a');
    }
  }
  if (target === null) {
    return false;
  }

  if (target.host === window.location.host && target.pathname === window.location.pathname && target.hash) {
    // probably a same page anchor link
    return false;
  }

  /*
  if (el.origin === window.location.origin) {
    if (!el.search) {
      // probably the same page
      return false;
    }
  }
  */

  el = null;
  // passed?
  return true;
};

export default ajaxableHref;
