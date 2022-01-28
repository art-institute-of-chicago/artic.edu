import { triggerCustomEvent } from '@area17/a17-helpers';

const globalSearchOpen = function(container) {

  function _handleClicks(event) {
    event.preventDefault();
    triggerCustomEvent(document, 'globalSearch:open');
    container.blur();
  }

  function _init() {
    container.addEventListener('click', _handleClicks, false);
  }

  this.destroy = function() {
    // Remove specific event handlers
    container.removeEventListener('click', _handleClicks);

    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default globalSearchOpen;
