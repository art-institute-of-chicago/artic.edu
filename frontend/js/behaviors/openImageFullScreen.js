import { purgeProperties, triggerCustomEvent } from '@area17/a17-helpers';

const openImageFullScreen = function(container) {

  function _handleClicks(event) {
    event.preventDefault();
    let data = {
      srcset: container.getAttribute('data-gallery-img-srcset') || container.parentNode.querySelector('img').getAttribute('srcset'),
      width: container.getAttribute('data-gallery-img-width') || container.parentNode.querySelector('img').getAttribute('width'),
      height: container.getAttribute('data-gallery-img-height') || container.parentNode.querySelector('img').getAttribute('height'),
      credit: container.getAttribute('data-gallery-img-credit') || '',
      creditUrl: container.getAttribute('data-gallery-img-credit-url') || '',
      shareUrl: container.getAttribute('data-gallery-img-share-url') || '',
      shareTitle: container.getAttribute('data-gallery-img-share-title') || '',
      downloadUrl: container.getAttribute('data-gallery-img-download-url') || '',
      downloadName: container.getAttribute('data-gallery-img-download-name') || '',
    }

    triggerCustomEvent(document, 'fullScreenImage:open', {
      img: data,
    });
  }

  function _init() {
    container.addEventListener('click', _handleClicks, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    container.removeEventListener('click', _handleClicks);

    // remove properties of this behavior
    purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default openImageFullScreen;
