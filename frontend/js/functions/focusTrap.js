import { setFocusOnTarget } from '@area17/a17-helpers';

const focusTrap = function() {

  let element;

  function _focus() {
    if (element && !element.contains(document.activeElement)) {
      setFocusOnTarget(element);
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
  }

  document.addEventListener('focus:trap', _trap, false);
  document.addEventListener('focus:untrap', _untrap, false);
};

export default focusTrap;
