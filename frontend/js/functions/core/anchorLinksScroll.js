import { setFocusOnTarget, scrollToY, getOffset, triggerCustomEvent } from '@area17/a17-helpers';

const anchorLinksScroll = function(container) {

  function _handleClicks(event) {
    if (event.target.host === window.location.host && event.target.pathname === window.location.pathname && event.target.hash) {
      event.preventDefault();
      event.stopPropagation();
      if (event.target.classList.contains('return-link')) {
        triggerCustomEvent(document, 'setScrollDirection:machineScroll', { 'machineScroll': true });
      }
      let updateHash = (window.location.hash !== event.target.hash);
      let hash = event.target.hash.replace('#','');
      let target = document.getElementById(hash); // Fails on quotes
      let offsetTarget = getOffset(target).top - 20;
      event.target.blur();
      scrollToY({
        el: document,
        offset: offsetTarget,
        duration: 500,
        easing: 'easeInOut',
        onComplete: function() {
          setTimeout(function(){ setFocusOnTarget(target); }, 0)
          if (event.target.classList.contains('return-link')) {
            triggerCustomEvent(document, 'setScrollDirection:machineScroll', { 'machineScroll': false });
          }
          if (updateHash) {
            if (hash === 'a17' || hash === 'content') {
              hash = window.location.href.replace(window.location.hash, '');
            } else {
              hash = '#' + hash;
            }
            triggerCustomEvent(document, 'history:pushstate', {
              url: hash,
              type: 'anchor',
              title: document.title,
            });
          }
        }
      });
    }
  }

  function _hashChange(event) {
    event.preventDefault();
    let target = document.body;
    let offsetTarget = 0;
    if (window.location.hash) {
      let hash = window.location.hash.replace('#','');
      target = document.getElementById(hash);
      offsetTarget = getOffset(target).top - 20;
    }
    scrollToY({
      el: document,
      offset: offsetTarget,
      duration: 500,
      easing: 'easeInOut',
      onComplete: function() {
        setTimeout(function(){ setFocusOnTarget(target); }, 0)
      }
    });
  }


  document.addEventListener('click', _handleClicks, false);
  window.addEventListener('hashchange', _hashChange, false);
};

export default anchorLinksScroll;
