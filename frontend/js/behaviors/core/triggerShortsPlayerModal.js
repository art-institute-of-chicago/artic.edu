import { triggerCustomEvent } from '@area17/a17-helpers';

const triggerShortsPlayerModal = function(container) {

  function _handleClicks(event) {
    event.preventDefault();
    event.stopPropagation();
    triggerCustomEvent(document, 'ajax:getPage', {
      url: container.dataset.href || container.getAttribute('href'),
      type: 'modal',
      opener: 'shorts',
    });
    triggerCustomEvent(document, 'gtm:push', {
      'event': container.dataset.gtmEvent || 'shorts-modal',
      'eventCategory': container.dataset.gtmEventCategory || 'video-engagement',
      'eventAction': container.dataset.gtmEventAction || '',
    });
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
