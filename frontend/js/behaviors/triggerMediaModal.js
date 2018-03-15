import { purgeProperties, triggerCustomEvent } from '@area17/a17-helpers';

const triggerMediaModal = function(container) {

  function _handleClicks(event) {
    var textarea = container.querySelector('textarea');
    if (textarea) {
      var embedCode = textarea.value;
      if (embedCode) {
        event.preventDefault();
        event.stopPropagation();
        console.log(embedCode);
        triggerCustomEvent(document, 'mediaModal:show', {
          embedCode: embedCode,
        });
      }
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

export default triggerMediaModal;

