import { purgeProperties, setFocusOnTarget, scrollToY, getOffset, triggerCustomEvent } from '@area17/a17-helpers';

const anchorLinksScroll = function(container) {

  function _handleClicks(event) {
    if (event.target.host === window.location.host && event.target.hash) {
      event.preventDefault();
      event.stopPropagation();
      if (event.target.classList.contains('return-link')) {
        triggerCustomEvent(document, 'setScrollDirection:machineScroll', { 'machineScroll': true });
      }
      let target = document.getElementById(event.target.hash.replace('#',''));
      let offsetTarget = getOffset(target).top - 20;
      window.location.hash = '';
      event.target.blur();
      scrollToY({
        el: document,
        offset: offsetTarget,
        duration: 500,
        easing: 'easeInOut',
        onComplete: function() {
          setFocusOnTarget(target);
          if (event.target.classList.contains('return-link')) {
            triggerCustomEvent(document, 'setScrollDirection:machineScroll', { 'machineScroll': false });
          }
        }
      });
    }
  }

  document.addEventListener('click', _handleClicks, false);
};

export default anchorLinksScroll;
