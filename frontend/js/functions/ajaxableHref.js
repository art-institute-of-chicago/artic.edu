const ajaxableHref = function(href, event) {
  // fail if no href or same page
  if (!href || href === '#' || href === window.location.href) {
    return false;
  }
  // fail if external or not same protocol
  var el = document.createElement('a');
  el.href = href;
  if (window.location.protocol !== el.protocol || window.location.hostname !== el.hostname) {
    // off site link
    return false;
  }
  if (event.target.host === window.location.host && event.target.pathname === window.location.pathname && event.target.hash) {
    // probably a same page anchor link
    return false;
  }
  el = null;
  // passed?
  return true;
};

export default ajaxableHref;
