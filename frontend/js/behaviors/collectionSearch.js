import { purgeProperties, triggerCustomEvent, setFocusOnTarget } from '@area17/a17-helpers';
import { focusTrap, mediaQuery } from '../functions';

const collectionSearch = function(container) {

  let active = false;

  function _showSearch() {
    if (active) {
      return;
    }
    triggerCustomEvent(document, 'body:lock', {
      breakpoints: 'all'
    });
    window.requestAnimationFrame(function(){
      document.documentElement.classList.add('s-collection-search-active');
      setTimeout(function(){ setFocusOnTarget(container); }, 0)
      triggerCustomEvent(document, 'focus:trap', {
        element: container
      });
      triggerCustomEvent(document, 'collectionSearch:visible');
      active = true;
    });
  }

  function _hideSearch() {
    if (!active) {
      return;
    }
    document.documentElement.classList.remove('s-collection-search-active');
    triggerCustomEvent(document, 'body:unlock');
    triggerCustomEvent(document, 'focus:untrap');
    setTimeout(function(){ setFocusOnTarget(document.getElementById('a17')); }, 0)
    triggerCustomEvent(document, 'collectionSearch:hidden');
    active = false;
  }

  function _mediaQueryUpdated() {
    if (active && mediaQuery('medium+')) {
      triggerCustomEvent(document, 'collectionSearch:close');
      setTimeout(function(){
        window.scrollTo(0, 0);
      }, 5);
    }
  }

  function _init() {
    document.addEventListener('collectionSearch:open', _showSearch, false);
    document.addEventListener('collectionSearch:close', _hideSearch, false);
    document.addEventListener('mediaQueryUpdated',_mediaQueryUpdated, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    document.removeEventListener('collectionSearch:open', _showSearch);
    document.removeEventListener('collectionSearch:close', _hideSearch);
    document.removeEventListener('mediaQueryUpdated',_mediaQueryUpdated);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default collectionSearch;
