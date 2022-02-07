import { triggerCustomEvent } from '@area17/a17-helpers';

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

    // PUB-30: Support gallery navigation
    let prevItem = null;
    let nextItem = null;
    let enableNavigation = false;

    if (container.getAttribute('data-modal-advanced') === 'true') {
      let gallery = container.closest('.o-gallery');

      if (gallery) {
        let galleryItems = gallery.querySelectorAll('[data-behavior*="openImageFullScreen"]');
        let currentIndex = Array.prototype.indexOf.call(galleryItems, container);

        prevItem = galleryItems[currentIndex - 1] || null;
        nextItem = galleryItems[currentIndex + 1] || null;

        if (prevItem || nextItem) {
          enableNavigation = true;
        }
      }
    }

    let data = {
      src: container.getAttribute('data-gallery-img-src') || container.parentNode.querySelector('img').src,
      srcset: container.getAttribute('data-gallery-img-srcset') || container.parentNode.querySelector('img').getAttribute('srcset') || container.parentNode.querySelector('img').getAttribute('data-srcset'),
      width: width,
      height: height,
      credit: container.getAttribute('data-gallery-img-credit') || container.getAttribute('data-credit'),
      creditUrl: container.getAttribute('data-gallery-img-credit-url') || '',
      shareUrl: container.getAttribute('data-gallery-img-share-url') || '',
      shareTitle: container.getAttribute('data-gallery-img-share-title') || '',
      downloadUrl: container.getAttribute('data-gallery-img-download-url') || '',
      downloadName: container.getAttribute('data-gallery-img-download-name') || '',
      iiifId: container.getAttribute('data-gallery-img-iiifId') || container.parentNode.querySelector('img').getAttribute('data-iiifId'),
      infoUrl: container.parentNode.querySelector('img').getAttribute('data-infourl') || '',
      restrict: container.getAttribute('data-restrict') || '',
      enableNavigation: enableNavigation,
      prevItem: prevItem,
      nextItem: nextItem,
    };

    triggerCustomEvent(document, 'fullScreenImage:open', {
      img: data,
    });
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
    // Remove specific event handlers
    container.removeEventListener('click', _handleClicks);
    container.removeEventListener('keyup', _handleKeyUp);

    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default openImageFullScreen;
