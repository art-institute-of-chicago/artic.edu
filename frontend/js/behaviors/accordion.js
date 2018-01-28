import { purgeProperties, triggerCustomEvent, setFocusOnTarget } from 'a17-helpers';

const accordion = function(container) {

  function _getHeightAndSet(target) {
    let targetHeight = target.firstElementChild.offsetHeight;
    target.style.height = targetHeight + 'px';
  }

  function _unsetAfterAnimation() {
    this.removeAttribute('style');
    this.removeEventListener('transitionend', _unsetAfterAnimation);
    triggerCustomEvent(document, 'page:updated');
  }

  function _toggle(event) {
    console.log(event.target.parentNode);
    if (event.target.classList.contains('o-accordion__trigger') || event.target.parentNode.classList.contains('o-accordion__trigger')) {
      event.preventDefault();
      event.stopPropagation();
      //
      let trigger = event.target.classList.contains('o-accordion__trigger') ? event.target : event.target.parentNode;
      let target = trigger.nextElementSibling;
      let validTarget = (target.classList.contains('o-accordion__panel'));
      //
      if (validTarget) {
        trigger.blur();
        if (trigger.getAttribute('aria-expanded') === 'true') {
          // close
          _getHeightAndSet(target);
          trigger.setAttribute('aria-expanded', 'false');
          target.setAttribute('aria-hidden', 'true');
          let thrash = target.offsetHeight;
          target.style.height = 0;
        } else {
          // open
          target.style.height = 0;
          trigger.setAttribute('aria-expanded', 'true');
          target.setAttribute('aria-hidden', 'false');
          setFocusOnTarget(target);
          _getHeightAndSet(target);
        }
        target.addEventListener('transitionend', _unsetAfterAnimation, false);
      }
    }
  }

  function _handleClicks(event) {
    _toggle(event);
  }

  function _handleKeyPress(event) {
    if (event.keyCode === 13 || event.keyCode === 8) {
      _toggle(event);
    }
  }

  function _handleFocus(event) {
    try {
      container.querySelector('.o-accordion__trigger.s-focus').classList.remove('s-focus');
    } catch(err) {
    }
    if (event.keyCode === 9 && container.contains(document.activeElement) && document.activeElement.classList.contains('o-accordion__trigger')) {
      document.activeElement.classList.add('s-focus');
    }
  }

  function _init() {
    container.addEventListener('click', _handleClicks, false);
    container.addEventListener('keyup', _handleKeyPress, false);
    window.addEventListener('keyup', _handleFocus, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    container.removeEventListener('click', _handleClicks);
    container.removeEventListener('keyup', _handleKeyPress);
    window.removeEventListener('keyup', _handleFocus);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default accordion;
