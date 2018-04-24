import { purgeProperties, triggerCustomEvent, setFocusOnTarget } from '@area17/a17-helpers';
import { focusTrap, mediaQuery } from '../functions';

const collectionFilters = function(container) {

  let active = false;

  function _showFilters() {
    if (active) {
      return;
    }
    document.documentElement.classList.add('s-collection-filters-active');
    if (mediaQuery('small-')) {
      triggerCustomEvent(document, 'body:lock', {
        breakpoints: 'all'
      });
      setFocusOnTarget(container);
      triggerCustomEvent(document, 'focus:trap', {
        element: container
      });
    }
    triggerCustomEvent(document, 'collectionFilters:visible');
    active = true;
  }

  function _hideFilters() {
    if (!active) {
      return;
    }
    document.documentElement.classList.remove('s-collection-filters-active');
    if (mediaQuery('small-')) {
      triggerCustomEvent(document, 'body:unlock');
      triggerCustomEvent(document, 'focus:untrap');
      setFocusOnTarget(document.getElementById('a17'));
    }
    triggerCustomEvent(document, 'collectionFilters:hidden');
    active = false;
  }

  function _toggleFilters() {
    if (!active) {
      triggerCustomEvent(document, 'collectionFilters:open');
    } else {
      triggerCustomEvent(document, 'collectionFilters:close');
    }
  }

  function _mediaQueryUpdated() {
    if (active) {
      triggerCustomEvent(document, 'collectionFilters:close');
      triggerCustomEvent(document, 'collectionFilters:open');
    }
  }

  function _init() {
    document.addEventListener('collectionFilters:open', _showFilters, false);
    document.addEventListener('collectionFilters:close', _hideFilters, false);
    document.addEventListener('collectionFilters:toggle', _toggleFilters, false);
    document.addEventListener('mediaQueryUpdated',_mediaQueryUpdated, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    document.removeEventListener('collectionFilters:open', _showFilters);
    document.removeEventListener('collectionFilters:close', _hideFilters);
    document.removeEventListener('collectionFilters:toggle', _hideFilters);
    document.removeEventListener('mediaQueryUpdated',_mediaQueryUpdated);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.destroy = function() {
    // remove specific event handlers

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default collectionFilters;
