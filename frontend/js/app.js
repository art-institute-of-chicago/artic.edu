import { manageBehaviors, resized, getCurrentMediaQuery } from 'a17-helpers';
import * as Behaviors from './behaviors';
import { lockBody, focusTrap } from './functions';

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

document.addEventListener('DOMContentLoaded', function(){
  // go go go
  manageBehaviors(Behaviors);
  // listen for body lock requests
  lockBody();
  // listen for focus trap requests
  focusTrap();
  // on resize, check
  resized();
});

// make console.log safe
if (typeof console === 'undefined') {
  window.console = {
    log: function () {
      return;
    }
  };
}
