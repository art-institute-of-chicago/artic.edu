import { setFocusOnTarget, purgeProperties, triggerCustomEvent } from '@area17/a17-helpers';
import { positionElementToTarget, focusTrap } from '../functions';

const sharePage = function(container) {

  const shareMenu = document.getElementById('shareMenu');
  let shareOpen = false;
  let icon;
  let iconClass;

  function _position() {
    positionElementToTarget({
      element: shareMenu,
      target: container,
      position: 'top left',
      padding: {
        top: 12
      },
      breakpoints: {
        xsmall: false,
        small: false,
        medium: true,
        large: true,
        xlarge: true,
      }
    });
  }

  function _reposition() {
    if (shareOpen) {
      setTimeout(_position, 100);
    }
  }

  function _mediaQueryUpdated() {
    if (shareOpen) {
      _closeShareMenu();
      _openShareMenu();
    }
  }

  function _updateIcon(state) {
    if (icon && iconClass) {
      if (state === 'default') {
        icon.setAttribute('class',iconClass);
        icon.querySelector('use').setAttribute('xlink:href','#'+iconClass);
      } else {
        icon.setAttribute('class','icon--close');
        icon.querySelector('use').setAttribute('xlink:href','#icon--close');
      }
    }
  }

  function _closeShareMenu() {
    if (shareOpen) {
      document.documentElement.classList.remove('s-shareMenu-active');
      triggerCustomEvent(document, 'body:unlock');
      shareMenu.removeAttribute('style');
      triggerCustomEvent(document, 'focus:untrap');
      setFocusOnTarget(container.parentNode);
      _updateIcon('default');
      container.classList.remove('s-active');
      shareOpen = false;
    }
  }

  function _openShareMenu(event) {
    if (event) {
      event.preventDefault();
      event.stopPropagation();
    }
    container.blur();
    if (!shareOpen) {
      triggerCustomEvent(document, 'body:lock', {
        breakpoints: 'xsmall small'
      });
      window.requestAnimationFrame(function(){
        shareOpen = true;
        container.classList.add('s-active');
        _updateIcon('active');
        document.documentElement.classList.add('s-shareMenu-active');
        _position();
        setFocusOnTarget(shareMenu);
        triggerCustomEvent(document, 'focus:trap', {
          element: shareMenu
        });
        triggerCustomEvent(shareMenu, 'shareMenu:opened', {
          url: container.getAttribute('data-share-url'),
          title: container.getAttribute('data-share-title'),
        });
      });
    } else {
      _closeShareMenu();
    }
  }

  function _toggleShareOpen(event) {
    if (shareOpen) {
      _closeShareMenu();
    } else {
      _openShareMenu(event);
    }
  }

  function _handleClicks(event) {
    event.preventDefault();
    event.stopPropagation();
    _toggleShareOpen(event);
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
    icon = container.querySelector('svg[class*=icon--]');
    iconClass = icon ? icon.getAttribute('class') : null;

    container.addEventListener('click', _handleClicks, false);
    document.addEventListener('shareMenu:close', _closeShareMenu, false);
    document.addEventListener('click', _clicksOutside, false);
    window.addEventListener('resized', _reposition, false);
    document.addEventListener('mediaQueryUpdated',_mediaQueryUpdated, false);
    window.addEventListener('keyup', _escape, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    container.removeEventListener('click', _handleClicks);
    document.removeEventListener('shareMenu:close', _closeShareMenu);
    document.removeEventListener('click', _clicksOutside);
    window.removeEventListener('resized', _reposition);
    document.removeEventListener('mediaQueryUpdated',_mediaQueryUpdated);
    window.removeEventListener('keyup', _escape);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default sharePage;
