import { purgeProperties, triggerCustomEvent, setFocusOnTarget } from 'a17-helpers';
import { focusTrap } from '../functions';

const collectionSearch = function(container) {

  let active = false;

  function _showSearch() {
    if (active) {
      return;
    }
    document.documentElement.classList.add('s-collection-search-active');
    triggerCustomEvent(document, 'body:lock', {
      breakpoints: 'all'
    });
    setFocusOnTarget(container);
    triggerCustomEvent(document, 'focus:trap', {
      element: container
    });
    triggerCustomEvent(document, 'collectionSearch:visible');
    active = true;
  }

  function _hideSearch() {
    if (!active) {
      return;
    }
    document.documentElement.classList.remove('s-collection-search-active');
    triggerCustomEvent(document, 'body:unlock');
    triggerCustomEvent(document, 'focus:untrap');
    setFocusOnTarget(document.getElementById('a17'));
    triggerCustomEvent(document, 'collectionSearch:hidden');
    active = false;
  }

  function _init() {
    document.addEventListener('collectionSearch:open', _showSearch, false);
    document.addEventListener('collectionSearch:close', _hideSearch, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    document.removeEventListener('collectionSearch:open', _showSearch);
    document.removeEventListener('collectionSearch:close', _hideSearch);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default collectionSearch;
