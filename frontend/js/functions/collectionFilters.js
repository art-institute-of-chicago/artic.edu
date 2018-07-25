import { purgeProperties, triggerCustomEvent, setFocusOnTarget } from '@area17/a17-helpers';
import { focusTrap, mediaQuery } from '../functions';

const collectionFilters = function(container) {

  let active = document.documentElement.classList.contains('s-collection-filters-active');
  let locked = false;


  function _showFilters() {
    if (active) {
      return;
    }

    active = true;

    if (mediaQuery('small-')) {
      triggerCustomEvent(document, 'body:lock', {
        breakpoints: 'all'
      });
      locked = true;
      window.requestAnimationFrame(function(){
        document.documentElement.classList.add('s-collection-filters-active');
        let container = document.getElementById('collectionFilters');
        if (container) {
          setTimeout(function(){ setFocusOnTarget(container); }, 0)
          triggerCustomEvent(document, 'focus:trap', {
            element: container
          });
        }
        triggerCustomEvent(document, 'collectionFilters:visible');
      });
    } else {
      document.documentElement.classList.add('s-collection-filters-active');
      triggerCustomEvent(document, 'collectionFilters:visible');
    }
  }

  function _hideFilters() {
    if (!active) {
      return;
    }
    //if (locked) {
      triggerCustomEvent(document, 'body:unlock');
      triggerCustomEvent(document, 'focus:untrap');
      setTimeout(function(){ setFocusOnTarget(document.getElementById('a17')); }, 0)
      locked = false;
    //}
    document.documentElement.classList.remove('s-collection-filters-active');
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

  document.addEventListener('collectionFilters:open', _showFilters, false);
  document.addEventListener('collectionFilters:close', _hideFilters, false);
  document.addEventListener('collectionFilters:toggle', _toggleFilters, false);
  document.addEventListener('mediaQueryUpdated',_mediaQueryUpdated, false);
};

export default collectionFilters;
