import { manageBehaviors, resized, getCurrentMediaQuery, forEach, lazyLoad } from '@area17/a17-helpers';
import * as Behaviors from './behaviors';
import { lockBody, focusTrap, focusDisplayHandler, ajaxPageLoad, ajaxPageLoadMaskToggle, historyProxy, loadProgressBar, setScrollDirection, anchorLinksScroll, fontObservers, modals } from './functions';
/*

  A17

  Doc: // Doc: https://code.area17.com/a17/fe-boilerplate/wikis/js-app

*/

var A17 = window.A17 || {};

// HTML4 browser?
if (!A17.browserSpec || A17.browserSpec === 'html4') {
  // lets kill further JS execution of A17 js here
  throw new Error('HTML4');
}

A17.currentMediaQuery = getCurrentMediaQuery();
A17.env = 'production';
A17.ajaxActive = false;
A17.failSafe = false;

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
  // update env
  try {
    A17.env = /s-env-([a-z]*)/ig.exec(document.documentElement.className)[1];
  } catch(err){
    A17.env = 'unknown';
  }
  // update ajax link active / fail safes
  A17.ajaxLinksActive = (A17.env === 'local') ? false : true;
  A17.ajaxLinksFailSafe = (A17.env === 'production') ? true : false;
  // go go go
  manageBehaviors(Behaviors);
  // listen for body lock requests
  lockBody();
  // listen for focus trap requests
  focusTrap();
  // workout focus type
  focusDisplayHandler();
  // scroll anchor links
  anchorLinksScroll();
  // listen for modal open/close requests (including roadblock close)
  modals();
  // listen for ajax page load type events
  ajaxPageLoad();
  ajaxPageLoadMaskToggle();
  historyProxy();
  loadProgressBar();
  // on resize, check
  resized();
  // handle sticky header and articleBodyInViewport
  setScrollDirection();
  // watch for fonts loading
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
  // lazy load images
  lazyLoad();
});

// make console.log safe
if (typeof console === 'undefined') {
  window.console = {
    log: function () {
      return;
    }
  };
}

// polyfil .closest
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
