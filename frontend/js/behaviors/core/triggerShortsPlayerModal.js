import { triggerCustomEvent, purgeProperties } from '@area17/a17-helpers';

const triggerShortsPlayerModal = function(container) {

  function _handleClicks(event) {
    // WEB-3326 Redirect Safari users to Shorts detail page
    if (isOutdatedSafari()) return;
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
    if (event.keyCode === 13) {
      _handleClicks(event);
    }
  }

  function isOutdatedSafari() {
    const userAgent = navigator.userAgent;
    const isSafari = userAgent.includes('Safari/') && !userAgent.includes('Chrome/');
    let isOutdated = false;
    const version = userAgent.match(/Version\/(\d+\.\d+)/);
    if (version) {
       isOutdated = parseFloat(version[1]) < 19;
    }
    console.debug(`isSafari: ${isSafari}, isOutdated: ${isOutdated}`);
    return isSafari && isOutdated;
  }

  this.destroy = function() {
    container.removeEventListener('click', _handleClicks);
    container.removeEventListener('keyup', _handleKeyUp);
    purgeProperties(this);
  };

  this.init = function() {
    container.addEventListener('click', _handleClicks, false);
    container.addEventListener('keyup', _handleKeyUp, false);
  };
};

export default triggerShortsPlayerModal;
