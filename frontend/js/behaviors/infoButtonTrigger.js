import { setFocusOnTarget, purgeProperties, triggerCustomEvent } from '@area17/a17-helpers';
import { positionElementToTarget, focusTrap } from '../functions';

const infoButtonTrigger = function(container) {

  const infoButtonInfo = document.getElementById('info-button-info');
  let infoOpen = false;

  function _position() {
    positionElementToTarget({
      element: infoButtonInfo,
      target: container,
      position: 'top left',
      padding: {
        top: 20
      },
      breakpoints: {
        xsmall: true,
        small: true,
        medium: true,
        large: true,
        xlarge: true,
      }
    });
  }

  function _reposition() {
    if (infoOpen) {
      setTimeout(_position, 100);
    }
  }

  function _closeInfoButtonInfo() {
    if (infoOpen) {
      document.documentElement.classList.remove('s-infoButtonInfo-active');
      infoButtonInfo.removeAttribute('style');
      triggerCustomEvent(document, 'focus:untrap');
      setFocusOnTarget(container.parentNode);
      infoButtonInfo.querySelector('span').textContent = '';
      infoOpen = false;
    }
  }

  function _openInfoButtonInfo(event) {
    event.preventDefault();
    event.stopPropagation();
    container.blur();
    if (!infoOpen) {
      infoButtonInfo.querySelector('span').textContent = container.querySelector('span').textContent;
      document.documentElement.classList.add('s-infoButtonInfo-active');
      _position();
      setFocusOnTarget(infoButtonInfo);
      triggerCustomEvent(document, 'focus:trap', {
        element: infoButtonInfo
      });
      infoOpen = true;
    } else {
      _closeInfoButtonInfo();
    }
  }

  function _toggleInfoButtonInfo(event) {
    if (infoOpen) {
      _closeInfoButtonInfo();
    } else {
      _openInfoButtonInfo(event);
    }
  }

  function _handleClicks(event) {
    event.preventDefault();
    event.stopPropagation();
    _toggleInfoButtonInfo(event);
    container.blur();
  }

  function _clicksOutside(event) {
    if (infoOpen) {
      event.preventDefault();
      event.stopPropagation();
      _closeInfoButtonInfo();
    }
  }

  function _escape(event) {
    var isInput = (event.target.tagName === 'INPUT');
    if (infoOpen && event.keyCode === 27 && !isInput) {
      _closeInfoButtonInfo();
    }
  }

  function _init() {
    container.addEventListener('click', _handleClicks, false);
    document.addEventListener('infoButtonInfo:close', _closeInfoButtonInfo, false);
    document.addEventListener('click', _clicksOutside, false);
    window.addEventListener('resized', _reposition, false);
    window.addEventListener('keyup', _escape, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    container.removeEventListener('click', _handleClicks);
    document.removeEventListener('infoButtonInfo:close', _closeInfoButtonInfo);
    document.removeEventListener('click', _clicksOutside);
    window.removeEventListener('resized', _reposition);
    window.removeEventListener('keyup', _escape);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default infoButtonTrigger;
