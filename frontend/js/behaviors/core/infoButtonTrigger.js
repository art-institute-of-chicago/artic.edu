import { setFocusOnTarget, triggerCustomEvent } from '@area17/a17-helpers';
import { positionElementToTarget } from '../../functions/core';

const infoButtonTrigger = function(container) {

  const infoButtonInfo = container.nextElementSibling || container.nextSibling;
  let infoOpen = false;
  let breakpoints = container.getAttribute('data-breakpoints') || 'all';

  function _position() {
    positionElementToTarget({
      element: infoButtonInfo,
      target: container,
      position: 'top left',
      padding: {
        top: 104,
        left: -76,
      },
      breakpoints: {
        xsmall: breakpoints.includes('xsmall') || breakpoints.includes('all'),
        small: breakpoints.includes('small') || breakpoints.includes('all'),
        medium: breakpoints.includes('medium') || breakpoints.includes('all'),
        large: breakpoints.includes('large') || breakpoints.includes('all'),
        xlarge: breakpoints.includes('xlarge') || breakpoints.includes('all'),
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
      container.setAttribute('aria-expanded','false');
      document.documentElement.classList.remove('s-infoButtonInfo-active');
      infoButtonInfo.removeAttribute('style');
      triggerCustomEvent(document, 'focus:untrap');
      setTimeout(function(){ setFocusOnTarget(container.parentNode); }, 0)
      infoButtonInfo.classList.add('s-hidden');
      infoOpen = false;
    }
  }

  function _openInfoButtonInfo(event) {
    event.preventDefault();
    event.stopPropagation();
    container.blur();
    if (!infoOpen) {
      container.setAttribute('aria-expanded','true');
      document.documentElement.classList.add('s-infoButtonInfo-active');
      _position();
      setTimeout(function(){ setFocusOnTarget(infoButtonInfo); }, 0)
      triggerCustomEvent(document, 'focus:trap', {
        element: infoButtonInfo
      });
      infoButtonInfo.classList.remove('s-hidden');
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
    if (infoOpen && !infoButtonInfo.contains(document.activeElement)) {
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
    // Remove specific event handlers
    container.removeEventListener('click', _handleClicks);
    document.removeEventListener('infoButtonInfo:close', _closeInfoButtonInfo);
    document.removeEventListener('click', _clicksOutside);
    window.removeEventListener('resized', _reposition);
    window.removeEventListener('keyup', _escape);

    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default infoButtonTrigger;
