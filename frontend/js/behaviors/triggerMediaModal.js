import { purgeProperties, triggerCustomEvent } from '@area17/a17-helpers';

const triggerMediaModal = function(container) {

  function _handleClicks(event) {
    var textarea = container.querySelector('textarea');
    if (textarea) {
      var embedCode = textarea.value;
      if (embedCode) {
        event.preventDefault();
        event.stopPropagation();
        triggerCustomEvent(document, 'modal:open', {
          type: 'media',
          embedCode: embedCode,
          subtype: container.getAttribute('data-subtype') || null,
        });
      }
    }
  }

  function _handleKeyUp(event) {
    if (event.keyCode == 13) {
      _handleClicks(event);
    }
  }

  function _init() {
    container.addEventListener('click', _handleClicks, false);
    container.addEventListener('keyup', _handleKeyUp, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    container.removeEventListener('click', _handleClicks);
    container.removeEventListener('keyup', _handleKeyUp);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default triggerMediaModal;

