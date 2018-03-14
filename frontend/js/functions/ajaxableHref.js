const ajaxableHref = function(href) {
  // fail if no href or same page
  if (!href || href.indexOf('#') > 0 || href === location.href) {
    return false;
  }
  // fail if external or not same protocol
  var el = document.createElement('a');
  el.href = href;
  if (window.location.protocol !== el.protocol || window.location.hostname !== el.hostname) {
    return false;
  }
  el = null;
  // passed?
  return true;
};

export default ajaxableHref;
