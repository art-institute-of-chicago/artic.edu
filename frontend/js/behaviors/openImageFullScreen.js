import { purgeProperties, triggerCustomEvent } from '@area17/a17-helpers';

const openImageFullScreen = function(container) {

  function _handleClicks(event) {
    event.preventDefault();
    event.stopPropagation();

    let width = container.getAttribute('data-gallery-img-width') || container.parentNode.querySelector('img').getAttribute('width');
    let height = container.getAttribute('data-gallery-img-height') || container.parentNode.querySelector('img').getAttribute('height');

    if (typeof width !== 'number' || width < 200) {
      let tempWidth = container.parentNode.querySelector('img').naturalWidth;
      if (typeof tempWidth === 'number' && tempWidth > width) {
        width = tempWidth;
      }
    }

    if (typeof height !== 'number' || height < 200) {
      let tempHeight = container.parentNode.querySelector('img').naturalHeight;
      if (typeof tempHeight === 'number' && tempHeight > height) {
        height = tempHeight;
      }
    }

    let data = {
      src: container.getAttribute('data-gallery-img-src') || container.parentNode.querySelector('img').src,
      srcset: container.getAttribute('data-gallery-img-srcset') || container.parentNode.querySelector('img').getAttribute('srcset'),
      width: width,
      height: height,
      credit: container.getAttribute('data-gallery-img-credit') || '',
      creditUrl: container.getAttribute('data-gallery-img-credit-url') || '',
      shareUrl: container.getAttribute('data-gallery-img-share-url') || '',
      shareTitle: container.getAttribute('data-gallery-img-share-title') || '',
      downloadUrl: container.getAttribute('data-gallery-img-download-url') || '',
      downloadName: container.getAttribute('data-gallery-img-download-name') || '',
      iiifId: container.getAttribute('data-gallery-img-iiifId') || container.parentNode.querySelector('img').getAttribute('data-iiifId'),
    };

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
