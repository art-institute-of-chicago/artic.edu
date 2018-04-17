import { purgeProperties, setFocusOnTarget, triggerCustomEvent } from '@area17/a17-helpers';
import { mediaQuery } from '../functions';

const dropdown = function(container) {

  var setup = false;
  var active = false;
  var allow = true;
  let breakpoints = container.getAttribute('data-dropdown-breakpoints') || 'all';

  function _open(event) {
    if (!allow) {
      return;
    }
    if (event) {
      event.stopPropagation();
    }
    triggerCustomEvent(document, 'dropdown:close');
    container.classList.add('s-active');
    setFocusOnTarget(container.querySelector('ul'));
    active = true;
  }

  function _globalOpen(event) {
    if (event && event.data.el && event.data.el === container && allow && !active) {
      _open();
    }
  }

  function _close(event) {
    if (!active) {
      return;
    }
    if (event) {
      /*
        FireFox has a bug going back to 2009 that affects the cursor showing in an input
        if event.stopPropagation() has been called on that input on focus:
        https://bugzilla.mozilla.org/show_bug.cgi?id=509684
        So, I'm seeing of the event is a focus event, if so seeing what the active
        element is. If its an input, then blurring the input to then re-focus it after
        the event.stopPropagation().
      */
      var activeElement = null;
      if (event.type === 'focus' && document.activeElement.tagName === 'INPUT') {
        activeElement = document.activeElement;
        activeElement.blur();
      }
      event.stopPropagation();
      if (activeElement) {
        window.requestAnimationFrame(function(){
          activeElement.focus();
        });
      }
    }
    container.classList.remove('s-active');
    active = false;
  }

  function _globalClose(event) {
    if (active) {
      _close();
    }
  }

  function _focus(event) {
    if (document.activeElement === container || container.contains(document.activeElement)) {
      event.stopPropagation();
      if (!active) {
        _open(event);
      } else if (document.activeElement === container || document.activeElement === container.firstElementChild) {
        _close(event);
        setFocusOnTarget(container.parentNode);
      }
    } else {
      _close(event);
    }
  }

  function _clicks(event) {
    if (document.activeElement !== container && !container.contains(document.activeElement) && active) {
      _close(event);
    }
  }

  function _touchstart(event) {
    if (event.target !== container && !container.contains(event.target) && active) {
      _close(event);
    }
  }

  function _touchend(event) {
    if ((event.target === container || container.contains(event.target)) && !active) {
      if (_ignore(event.target)) {
        allow = false;
        setTimeout(function(){
          allow = true;
        }, 100);
      } else {
        event.preventDefault();
        container.focus();
      }
    }
  }

  function _setup() {
    if (!setup) {
      container.setAttribute('tabindex','0');
      active = container.classList.contains('s-active');
      document.addEventListener('focus', _focus, true);
      document.addEventListener('click', _clicks, false);
      document.addEventListener('touchstart', _touchstart, false);
      document.addEventListener('touchend', _touchend, false);
      document.addEventListener('dropdown:open', _globalOpen, false);
      document.addEventListener('dropdown:close', _globalClose, false);
      setup = true;
    }
  }

  function _destroy() {
    if (setup) {
      active = false;
      document.removeEventListener('focus', _focus);
      document.removeEventListener('click', _clicks);
      document.removeEventListener('touchstart', _touchstart);
      document.removeEventListener('touchend', _touchend);
      document.removeEventListener('dropdown:open', _globalOpen);
      document.removeEventListener('dropdown:close', _globalClose);
      setup = false;
    }
  }

  function _mediaQueryUpdated() {
    if (!setup && mediaQuery(breakpoints)) {
      _setup();
    } else if (setup && !mediaQuery(breakpoints)) {
      _destroy();
    }
  }

  function _init() {
    document.addEventListener('mediaQueryUpdated', _mediaQueryUpdated, true);
    _mediaQueryUpdated();
  }

  this.destroy = function() {
    document.removeEventListener('mediaQueryUpdated', _mediaQueryUpdated);
    _destroy();

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default dropdown;
