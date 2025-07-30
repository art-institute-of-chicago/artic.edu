const ajaxableHref = function(href, event) {

  // Fail if no href
  if (!href || href === '#') {
    return false;
  }

  // Fail if external or not same protocol
  var el = document.createElement('a');
  el.href = href;
  if (window.location.protocol !== el.protocol || window.location.hostname !== el.hostname) {
    // Off site link
    return false;
  }

  // Sometimes the target is an element within the anchor
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
    // Probably a same page anchor link
    return false;
  }

  if (target.host === window.location.host && target.pathname === window.location.pathname) {
    // Use Ajax for same page anchor link
    return true;
  }

  // Disbale all other Ajax page loads [ART-52]
  return false;
};

export default ajaxableHref;
