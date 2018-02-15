import { purgeProperties, triggerCustomEvent } from 'a17-helpers';

const globalSearchClose = function(container) {

  function _handleClicks(event) {
    event.preventDefault();
    triggerCustomEvent(document, 'globalSearch:close');
    container.blur();
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

export default globalSearchClose;
