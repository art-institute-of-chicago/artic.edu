import { manageBehaviors, resized, getCurrentMediaQuery, forEach, lazyLoad } from '@area17/a17-helpers';
import * as Behaviors from './behaviors/core';
import { lockBody, focusTrap, focusDisplayHandler, ajaxPageLoad, ajaxPageLoadMaskToggle, historyProxy, loadProgressBar, setScrollDirection, anchorLinksScroll, fontObservers, modals, collectionFilters, googleTagManager, accessibleContent, headerHeight, roadblock } from './functions/core';
/**
 * A17
 * @see Doc: https://code.area17.com/a17/fe-boilerplate/wikis/js-app
 */
var A17 = window.A17 || {};

// HTML4 browser?
if (!A17.browserSpec || A17.browserSpec === 'html4') {
  // Let's kill further JS execution of A17 js here
  throw new Error('HTML4');
}

A17.currentMediaQuery = getCurrentMediaQuery();
A17.currentPathname = window.location.pathname;
A17.dateRangeValues = [
    '8000 BCE','7000 BCE','6000 BCE','5000 BCE','4000 BCE','3000 BCE','2000 BCE','1000 BCE','1 CE','500 CE','1000 CE','1200','1400','1600','1700','1800','1900','1910','1920','1930','1940','1950','1960','1970','1980','1990','2000','2010','2020','Present']; // For collection filters
A17.onYouTubeIframeAPIReady = false;
try {
  A17.env = /s-env-([a-z]*)/ig.exec(document.documentElement.className)[1];
} catch(err){
  A17.env = 'unknown';
}
A17.ajaxLinksActive = true;
A17.ajaxLinksFailSafe = (A17.env === 'production') ? true : false;

// Expose A17 so it's visible to kiosk
window.A17 = A17;

document.addEventListener('DOMContentLoaded', function(){
  if (A17.print) {
    forEach(document.querySelectorAll('[data-src]'), function(index, el) {
      try {
        el.src = el.getAttribute('data-src');
      } catch(err) {}
    });
    forEach(document.querySelectorAll('[data-srcset]'), function(index, el) {
      try {
        el.srcset = el.getAttribute('data-srcset');
      } catch(err) {}
    });
    return;
  }
  // Rebind "Skip to Content" target
  accessibleContent();
  // Listen for google tag manager dataLayer pushes
  googleTagManager();
  // Go go go!
  manageBehaviors(Behaviors);
  // Listen for body lock requests
  lockBody();
  // Listen for focus trap requests
  focusTrap();
  // Workout focus type
  focusDisplayHandler();
  // Scroll anchor links
  anchorLinksScroll();
  // Listen for modal open/close requests
  modals();
  // Listen for modal open/close requests
  roadblock();
  // Listen for calls to show/hide collection filters
  collectionFilters();
  // Listen for ajax page load type events
  ajaxPageLoad();
  ajaxPageLoadMaskToggle();
  historyProxy();
  loadProgressBar();
  // On resize, check
  resized();
  // Handle sticky header and articleBodyInViewport
  setScrollDirection();
  // Adjust header for closure notifications if needed
  headerHeight();
  // Watch for fonts loading
  fontObservers({
    name: 'serif',
    variants: [
      {
        name: 'Sabon',
        weight: '400',
        style: 'normal'
      },
      {
        name: 'Sabon',
        weight: '400',
        style: 'italic'
      },
      {
        name: 'Sabon',
        weight: '500',
        style: 'normal'
      },
    ]
  });
  fontObservers({
    name: 'sans-serif',
    variants: [
      {
        name: 'Ideal Sans A',
      },
      {
        name: 'Ideal Sans B',
        weight: '400',
        style: 'italic'
      },
    ]
  });
  // Lazy load images
  lazyLoad({
    rootMargin: '200px 0px',
    threshold: 0.01,
    maxFrameCount: 20
  });
});

window.onYouTubeIframeAPIReady = function() {
  A17.onYouTubeIframeAPIReady = true;
}

// Make console.log safe
if (typeof console === 'undefined') {
  window.console = {
    log: function () {
      return;
    }
  };
}

document.addEventListener('ajaxPageLoad:complete', function _setScrollRestoration(){
  if ('scrollRestoration' in history) {
    history.scrollRestoration = 'manual';
    document.removeEventListener('ajaxPageLoad:complete', _setScrollRestoration);
  }
}, false);

// Polyfil .closest
if (window.Element && !Element.prototype.closest) {
  Element.prototype.closest =
  function(s) {
    var matches = (this.document || this.ownerDocument).querySelectorAll(s),
      i,
      el = this;
    do {
      i = matches.length;
      while (--i >= 0 && matches.item(i) !== el) {};
    } while ((i < 0) && (el = el.parentElement));
    return el;
  };
}
