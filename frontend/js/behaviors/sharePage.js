import { setFocusOnTarget, purgeProperties, triggerCustomEvent } from 'a17-helpers';
import { positionElementToTarget } from '../functions';

const sharePage = function(container) {

  const shareMenu = document.getElementById('shareMenu');
  let shareOpen = false;

  function _position() {
    positionElementToTarget({
      element: shareMenu,
      target: container,
      position: 'top left',
      padding: {
        top: 20
      },
      breakpoints: {
        xsmall: false,
        small: false,
        medium: true,
        large: true,
        xlarge: true,
        xxlarge: true,
      }
    });
  }

  function _reposition() {
    if (shareOpen) {
      setTimeout(_position, 100);
    }
  }

  function _closeShareMenu() {
    if (shareOpen) {
      document.documentElement.classList.remove('s-shareMenu-active');
      shareMenu.removeAttribute('style');
      setFocusOnTarget(container.parentNode);
      shareOpen = false;
    }
  }

  function _openShareMenu(event) {
    event.preventDefault();
    event.stopPropagation();
    container.blur();
    if (!shareOpen) {
      document.documentElement.classList.add('s-shareMenu-active');
      triggerCustomEvent(shareMenu, 'shareMenu:opened', {
        url: container.getAttribute('data-share-url'),
        title: container.getAttribute('data-share-title'),
      });
      _position();
      setFocusOnTarget(shareMenu);
      shareOpen = true;
    } else {
      _closeShareMenu();
    }
  }

  function _toggleCalendar(event) {
    if (shareOpen) {
      _closeShareMenu();
    } else {
      _openShareMenu(event);
    }
  }

  function _handleClicks(event) {
    event.preventDefault();
    event.stopPropagation();
    _toggleCalendar(event);
  }

  function _clicksOutside(event) {
    if (shareOpen) {
      event.preventDefault();
      event.stopPropagation();
      _closeShareMenu();
    }
  }

  function _escape(event) {
    var isInput = (event.target.tagName === 'INPUT');
    if (shareOpen && event.keyCode === 27 && !isInput) {
      _closeShareMenu();
    }
  }

  function _init() {
    container.addEventListener('click', _handleClicks, false);
    document.addEventListener('shareMenu:close', _closeShareMenu, false);
    document.addEventListener('click', _clicksOutside, false);
    window.addEventListener('resized', _reposition, false);
    window.addEventListener('keyup', _escape, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    container.removeEventListener('click', _handleClicks);
    document.removeEventListener('shareMenu:close', _closeShareMenu);
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

export default sharePage;
