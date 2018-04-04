import { purgeProperties, setFocusOnTarget } from '@area17/a17-helpers';
import { positionElementToTarget } from '../functions';

const dropdown = function(container) {

  let active = false;
  let allow = true;
  let $list;
  let $listClone;

  /*
      Find a html element's position.
      Adapted from Peter-Paul Koch of QuirksMode at   http://www.quirksmode.org/js/findpos.html
  */
  function _findScrollLeft(obj) {
    var scrollLeft = 0;
    while(obj && obj.parentNode)
    {
      scrollLeft += (obj.parentNode.scrollLeft) ? obj.parentNode.scrollLeft : 0;
      obj = obj.parentNode;
    }
    return scrollLeft;
  }

  function _ignore(el) {
    let ignore = false;
    while (container.contains(el) && el !== container) {
      if (el.getAttribute('data-dropdown-ignore') !== null) {
        ignore = true;
      }
      el = el.parentNode;
    }
    return ignore;
  }

  function _removeClone(clone) {
    document.body.removeChild(clone);
  }

  function _open(event) {
    if (!allow || $listClone) {
      return;
    }
    if (event) {
      event.stopPropagation();
    }
    $listClone = $list.cloneNode(true);
    let minWidth = Math.round(container.offsetWidth);
    let top = 0;
    let left = 0;
    document.body.appendChild($listClone);
    if (A17.currentMediaQuery === 'xsmall') {
      left = 'auto';
    }
    if (container.classList.contains('dropdown--filter')) {
      minWidth = Math.round(container.offsetWidth + 32);
      top = Math.round(container.offsetHeight * -1);
      left = -16;
    }
    $listClone.style.minWidth = minWidth + 'px';
    $listClone.style.display = 'block';
    positionElementToTarget({
      element: $listClone,
      target: container,
      padding: {
        left: left,
        top: top
      }
    });
    container.classList.add('s-active');
    setFocusOnTarget($listClone);
    active = true;
  }

  function _close(event,type) {
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
      let activeElement = null;
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
    if (type === 'touchStart') {
      // need this 200ms delay for touch devices and the anchor link scrolling
      setTimeout(_removeClone.bind(null, $listClone), 200);
    } else {
      _removeClone($listClone);
    }
    $listClone = null;
    active = false;
    if (event) {
      setFocusOnTarget(container.parentNode);
    }
  }

  function _focus(event) {
    if (document.activeElement === container || container.contains(document.activeElement) || ($listClone && (document.activeElement === $listClone || $listClone.contains(document.activeElement)))) {
      if (!active) {
        if (document.activeElement.getAttribute('data-dropdown-ignore') === null) {
          _open(event);
        }
      } else if (document.activeElement === container || document.activeElement === container.firstElementChild) {
        _close(event);
      }
    } else {
      _close();
    }
  }

  function _clicks(event) {
    if (active) {
      if (document.activeElement !== container && !container.contains(document.activeElement) && $listClone && document.activeElement !== $listClone && !$listClone.contains(document.activeElement)) {
        _close(event);
      } else {
        _close();
      }
    }
  }

  function _touchstart(event) {
    if (active) {
      if (event.target !== container && !container.contains(event.target) && $listClone && event.target !== $listClone && !$listClone.contains(event.target)) {
        _close(event,'touchStart');
      } else {
        _close(null,'touchStart');
      }
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

  function _init() {
    container.setAttribute('tabindex','0');
    $list = container.querySelector('[data-dropdown-list]');
    active = container.classList.contains('s-active');
    document.addEventListener('focus', _focus, true);
    document.addEventListener('click', _clicks, false);
    document.addEventListener('touchstart', _touchstart, false);
    document.addEventListener('touchend', _touchend, false);
    container.addEventListener('dropdown:open', _open, false);
    container.addEventListener('dropdown:close', _close, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    document.removeEventListener('focus', _focus);
    document.removeEventListener('click', _clicks);
    document.removeEventListener('touchstart', _touchstart);
    document.removeEventListener('touchend', _touchend);
    container.removeEventListener('dropdown:open', _open);
    container.removeEventListener('dropdown:close', _close);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default dropdown;
