import { purgeProperties, setFocusOnTarget, scrollToY, getOffset } from '@area17/a17-helpers';

const internalLinksScroll = function(container) {

  function _handleClicks(event) {
    let hash = event.target.href;
    if (event.target.host === window.location.host && event.target.hash) {
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
        }
      });
      event.preventDefault();
    }
  }

  function _init() {
    container.addEventListener('click', _handleClicks, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    container.removeEventListener('click', _handleClicks);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default internalLinksScroll;
