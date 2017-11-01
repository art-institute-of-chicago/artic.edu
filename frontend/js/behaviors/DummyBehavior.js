import { purgeProperties } from 'a17-helpers';

var dummyBehavior = function(container) {

  function _handleClicks() {
    // action
  }

  function _handleResized() {
    // action
  }

  function _init() {
    container.addEventListener('click', _handleClicks, false);
    document.addEventListener('resized', _handleResized);
  }

  this.destroy = function() {
    // remove specific event handlers
    container.removeEventListener('click', _handleClicks);
    document.removeEventListener('resized', _handleResized);

    // remove properties of this behavior
    purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default dummyBehavior;
