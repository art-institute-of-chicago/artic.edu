import { triggerCustomEvent } from '@area17/a17-helpers';

const triggerShortsPlayerModal = function(container) {

  function _handleClicks(event) {
    var textarea = container.querySelector('textarea');
    if (!textarea) textarea = container.parentNode.querySelector('textarea');
    if (textarea) {
      var embedCode = textarea.value;
      if (embedCode) {
        event.preventDefault();
        event.stopPropagation();
        triggerCustomEvent(document, 'modal:open', {
          type: 'media',
          restricted: (container.parentNode.dataset.restricted == 'true') ? true : false,
          module3d: (container.parentNode.dataset.type == 'module3d') ? true : false,
          module360: (container.parentNode.dataset.type == 'module360') ? true : false,
          moduleMirador: (container.parentNode.dataset.type == 'moduleMirador') ? true : false,
          embedCode: embedCode,
          subtype: container.getAttribute('data-subtype') || null,
        });
        triggerCustomEvent(document, 'gtm:push', {
          'event': container.parentNode.dataset.gtmEvent || (container.parentNode.dataset.type + '-open-modal'),
          'eventCategory': container.parentNode.dataset.gtmEventCategory || 'in-page',
          'eventAction': container.parentNode.dataset.gtmEventAction || (container.parentNode.dataset.title+' - ' + container.parentNode.dataset.type)
        });
      }
    }
  }

  function _handleKeyUp(event) {
    if (event.keyCode == 13) {
      _handleClicks(event);
    }
  }

  this.destroy = function() {
    container.removeEventListener('click', _handleClicks);
    container.removeEventListener('keyup', _handleKeyUp);

    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    container.addEventListener('click', _handleClicks, false);
    container.addEventListener('keyup', _handleKeyUp, false);
  };
};

export default triggerShortsPlayerModal;
