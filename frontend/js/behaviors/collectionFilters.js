import { purgeProperties, triggerCustomEvent, setFocusOnTarget } from 'a17-helpers';
import { focusTrap } from '../functions';

const collectionFilters = function(container) {

  let active = false;

  function _showFilters() {
    if (active) {
      return;
    }
    document.documentElement.classList.add('s-collection-filters-active');
    triggerCustomEvent(document, 'body:lock', {
      breakpoints: 'xsmall small medium large xlarge xxlarge'
    });
    setFocusOnTarget(container);
    triggerCustomEvent(document, 'focus:trap', {
      element: container
    });
    triggerCustomEvent(document, 'collectionFilters:visible');
    active = true;
  }

  function _hideFilters() {
    if (!active) {
      return;
    }
    document.documentElement.classList.remove('s-collection-filters-active');
    triggerCustomEvent(document, 'body:unlock');
    triggerCustomEvent(document, 'focus:untrap');
    setFocusOnTarget(document.getElementById('a17'));
    triggerCustomEvent(document, 'collectionFilters:hidden');
    active = false;
  }

  function _init() {
    document.addEventListener('collectionFilters:open', _showFilters, false);
    document.addEventListener('collectionFilters:close', _hideFilters, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    document.removeEventListener('collectionFilters:open', _showFilters);
    document.removeEventListener('collectionFilters:close', _hideFilters);

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
