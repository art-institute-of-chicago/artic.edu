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

  if (target.pathname.startsWith('/assets/')) {
    // Link targets a DAMS asset
    return false;
  }

  if (target.pathname.startsWith('/pdf/static/')) {
    // Link targets a PDF download
    return false;
  }

  if (target.pathname.includes('/interactive-features/')) {
    // Link targets an interactive feature
    return false;
  }

  if (window.location.pathname.includes('/interactive-features/')) {
    // User is in an interactive feature
    return false;
  }

  // Link targets any pages that load additional Javascript
  if (target.pathname.includes('/articles/')
      || target.pathname.includes('/artworks/')
      || target.pathname.includes('/digital-publications/')
      || target.pathname.includes('/exhibitions/')
      || target.pathname.includes('/highlights/')
      || target.pathname.includes('/artinstitutereview')
      || target.pathname.includes('/videos/')
      || target.pathname.includes('/virtual-tours/')
      || target.pathname.includes('/collection')
      || target.pathname.includes('/events')) {
    return false;
  }

  if (window.location.pathname.includes('/articles/')
      || window.location.pathname.includes('/artworks/')
      || window.location.pathname.includes('/digital-publications/')
      || window.location.pathname.includes('/exhibitions/')
      || window.location.pathname.includes('/highlights/')
      || window.location.pathname.includes('/artinstitutereview')
      || window.location.pathname.includes('/videos/')
      || window.location.pathname.includes('/virtual-tours/')
      || window.location.pathname.includes('/collection')
      || window.location.pathname.includes('/events')) {
    return false;
  }

  el = null;
  // Passed?
  return true;
};

export default ajaxableHref;
