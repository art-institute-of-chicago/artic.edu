import { purgeProperties, setFocusOnTarget, forEach, getIndex, triggerCustomEvent } from '@area17/a17-helpers';
import { focusTrap } from '../functions';

const imageZoomArea = function(container) {

  const maxZoomLevel = 3;
  const maxImgDim = 3000;

  let eventData = null;
  let zoomable = null;
  let active = false;

  let btnZoomIn, btnZoomOut, btnClose, btnShare, img;

  let currentZoomLevel = 0;
  let zoomFactor = 0;
  let initZoomFactor = 0;

  let imgWidth = 0;
  let initImgWidth = 0;
  let imgHeight = 0;
  let initImgHeight = 0;
  let containerDims = [];
  let imgDims = [];

  function _zoomIn(event) {
    event.preventDefault();
    btnZoomIn.blur();
  }

  function _zoomOut(event) {
    event.preventDefault();
    btnZoomOut.blur();
  }

  function _handleResized() {
  }

  function _close(event) {
    if (!active) {
      return;
    }
    document.documentElement.classList.remove('s-fullscreenImage-active');
    container.classList.remove('s-zoomable');
    triggerCustomEvent(document, 'body:unlock');
    triggerCustomEvent(document, 'focus:untrap');
    setFocusOnTarget(document.getElementById('a17'));
    img.removeAttribute('width');
    img.removeAttribute('height');
    img.removeAttribute('srcset');
    img.removeAttribute('sizes');
    eventData = null;
    zoomable = null;
    active = false;
  }

  function _finishNonZoomOpen() {

    if (initImgWidth === 0 || initImgHeight === 0) {
      img.removeEventListener('load', _finishNonZoomOpen);
      initImgWidth = img.naturalWidth;
      initImgHeight = img.naturalHeight;
    }

    img.setAttribute('width', initImgWidth);
    img.setAttribute('height', initImgHeight);
    img.setAttribute('src', eventData.src);
    img.setAttribute('srcset', eventData.srcset);
    img.setAttribute('sizes','(min-width: 1280px) 1280px, (min-height: 1024px) 1280px, 100vw');

    if (window.picturefill) {
      window.picturefill(img);
    }
  }

  function _open(event) {
    if (active || !event || !event.data || !event.data.img) {
      return;
    }

    eventData = event.data.img;
    zoomable = (event.data.zoomable && event.data.zoomable === true);

    document.documentElement.classList.add('s-fullscreenImage-active');
    triggerCustomEvent(document, 'body:lock', {
      breakpoints: 'all'
    });
    setFocusOnTarget(container);
    triggerCustomEvent(document, 'focus:trap', {
      element: container
    });

    if (zoomable) {
      container.classList.add('s-zoomable');
    } else {
      container.classList.remove('s-zoomable');
      if (event.data.img.width !== 'auto' && event.data.img.height !== 'auto') {
        initImgWidth = parseInt(event.data.img.width);
        initImgHeight = parseInt(event.data.img.height);
        _finishNonZoomOpen();
      } else {
        initImgWidth = 0;
        initImgHeight = 0;
        img.addEventListener('load', _finishNonZoomOpen, false);
        img.setAttribute('srcset', eventData.srcset);
      }
    }

    btnShare.setAttribute('data-share-url', eventData.shareUrl);
    btnShare.setAttribute('data-share-title', eventData.shareTitle);

    _handleResized();

    active = true;
  }

  function _init() {
    img = container.querySelector('img');

    btnZoomIn = container.querySelector('[data-fullscreen-zoom-in]');
    btnZoomOut = container.querySelector('[data-fullscreen-zoom-out]');
    btnClose = container.querySelector('[data-fullscreen-close]');
    btnShare = container.querySelector('[data-fullscreen-share]');

    btnZoomIn.disabled = false;
    btnZoomOut.disabled = true;

    btnZoomIn.addEventListener('click', _zoomIn, false);
    btnZoomOut.addEventListener('click', _zoomOut, false);
    btnClose.addEventListener('click', _close, false);
    document.addEventListener('resized', _handleResized);
    document.addEventListener('fullScreenImage:open', _open, false);
    document.addEventListener('fullScreenImage:close', _close, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    btnZoomIn.removeEventListener('click', _zoomIn);
    btnZoomOut.removeEventListener('click', _zoomOut);
    btnClose.removeEventListener('click', _close);
    document.removeEventListener('resized', _handleResized);
    document.removeEventListener('fullScreenImage:open', _open);
    document.removeEventListener('fullScreenImage:close', _close);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default imageZoomArea;
