import { triggerCustomEvent, setFocusOnTarget } from '@area17/a17-helpers';
import { mediaQuery } from '../core';

const collectionFilters = function(container) {

  let savedFocus;
  let savedScroll;
  let active = document.documentElement.classList.contains('s-collection-filters-active');

  function _showFilters() {
    if (active) {
      return;
    }

    active = true;

    if (mediaQuery('small-')) {
      savedScroll = window.scrollY;
      savedFocus = document.activeElement || document.querySelector('body');
      triggerCustomEvent(document, 'body:lock', {
        breakpoints: 'all'
      });
      window.requestAnimationFrame(function(){
        document.documentElement.classList.add('s-collection-filters-active');
        let container = document.getElementById('collectionFilters');
        if (container) {
          setTimeout(function(){ setFocusOnTarget(container); }, 0)
          triggerCustomEvent(document, 'focus:trap', {
            element: container
          });
        }
      });
    } else {
      document.documentElement.classList.add('s-collection-filters-active');
    }
  }

  function _hideFilters() {
    if (!active) {
      return;
    }
    triggerCustomEvent(document, 'body:unlock');
    triggerCustomEvent(document, 'focus:untrap');
    setTimeout(function(){
      setFocusOnTarget(savedFocus);
      setTimeout(function(){
        window.scroll(0, savedScroll);
      }, 0);
    }, 0)
    document.documentElement.classList.remove('s-collection-filters-active');
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
