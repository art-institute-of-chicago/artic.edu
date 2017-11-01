import { manageBehaviors, resized } from 'a17-helpers';
import * as Behaviors from './behaviors';

/*

  A17

  Doc: // Doc: https://code.area17.com/a17/fe-boilerplate/wikis/js-app

*/

// HTML4 browser?
if (!A17.browserSpec || A17.browserSpec === 'html4') {
  // lets kill further JS execution of A17 js here
  throw new Error('HTML4');
}

document.addEventListener('DOMContentLoaded', function(){
  // go go go
  manageBehaviors(Behaviors);

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
