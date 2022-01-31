import { setFocusOnTarget } from '@area17/a17-helpers';

const focusTrap = function() {

  let element;

  function _focus() {
    if (element) {
      if (document.activeElement !== element && !element.contains(document.activeElement)) {
        setTimeout(function(){ setFocusOnTarget(element); }, 0)
      }
    } else {
      document.removeEventListener('focus', _trap);
    }
  }

  function _trap(event) {
    try {
      document.removeEventListener('focus', _focus);
    } catch(err) {}

    if (!event && !event.data.element) {
      return;
    }

    element = event.data.element;
    document.addEventListener('focus', _focus, true);
  }

  function _untrap() {
    document.removeEventListener('focus', _trap);
    element = null;
  }

  document.addEventListener('focus:trap', _trap, false);
  document.addEventListener('focus:untrap', _untrap, false);
};

export default focusTrap;
