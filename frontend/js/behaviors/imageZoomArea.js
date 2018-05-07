import { purgeProperties, setFocusOnTarget, forEach, getIndex, triggerCustomEvent } from '@area17/a17-helpers';
import { focusTrap } from '../functions';

const imageZoomArea = function(container) {

  const maxZoomLevel = 3;
  const maxImgDim = 3000;

  let osd;
  let eventData = null;
  let active = false;

  let $btnZoomIn, $btnZoomOut, $btnClose, $btnShare, $img, $osd;

  let imgWidth = 0;
  let imgHeight = 0;

  function _zoomIn(event) {
    event.preventDefault();
    $btnZoomIn.blur();
  }

  function _zoomOut(event) {
    event.preventDefault();
    $btnZoomOut.blur();
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
    $img.removeAttribute('width');
    $img.removeAttribute('height');
    $img.removeAttribute('srcset');
    $img.removeAttribute('sizes');
    $img.removeAttribute('src');
    if (osd) {
      osd.removeAllHandlers();
      osd.destroy();
      osd = null;
      $osd.innerHTML = '';
    }
    eventData = null;
    active = false;
  }

  function _finishNonZoomOpen() {

    if (imgWidth === 0 || imgHeight === 0) {
      $img.removeEventListener('load', _finishNonZoomOpen);
      imgWidth = $img.naturalWidth;
      imgHeight = $img.naturalHeight;
    }

    $img.setAttribute('width', imgWidth);
    $img.setAttribute('height', imgHeight);
    $img.setAttribute('src', eventData.src);
    $img.setAttribute('srcset', eventData.srcset);
    $img.setAttribute('sizes','(min-width: 1280px) 1280px, (min-height: 1024px) 1280px, 100vw');

    if (window.picturefill) {
      window.picturefill($img);
    }
  }

  function _finishZoomOpen(id) {

    osd = OpenSeadragon({
      id: "openseadragon",
      prefixUrl: location.protocol + "//openseadragon.github.io/openseadragon/images/",
      preserveViewport: true,
      springStiffness: 15,
      visibilityRatio: 1,
      zoomPerScroll: 1,
      zoomPerClick: 1.3,
      immediateRender:false,
      constrainDuringPan: true,
      animationTime: 1.5,
      minZoomLevel: 0,
      minZoomImageRatio: 0.8,
      maxZoomPixelRatio: 1.0,
      defaultZoomLevel: 0,
      gestureSettingsMouse: {
        scrollToZoom: false
      },
      zoomInButton: "osd_zoomInButton",
      zoomOutButton: "osd_zoomOutButton",
      showZoomControl: true,
      showHomeControl: true,
      showFullPageControl: false,
      showRotationControl: false,
      showSequenceControl: false,
      tileSources: [
        {
          "@context":"http://iiif.io/api/image/2/context.json",
          "@id": id,
          "protocol":"http://iiif.io/api/image",
          "width": imgWidth,
          "height": imgHeight,
          "tile_height": 256,
          "tile_width": 256,
          "scale_factors": [1, 2, 4, 8],
          "profile":[
            "http://iiif.io/api/image/2/level2.json",
            {
              "formats": ["jpg","tif","gif","png"],
              "qualities": ["bitonal","default","gray","color"],
            }
          ]
        }
      ]
    });


    osd.addHandler("zoom", function (data) {
      if (data.zoom <= osd.viewport.getMinZoom()) {
        $btnZoomIn.disabled = false;
        $btnZoomOut.disabled = true;
      } else if (data.zoom >= osd.viewport.getMaxZoom()) {
        $btnZoomIn.disabled = true;
        $btnZoomOut.disabled = false;
      } else {
        $btnZoomIn.disabled = false;
        $btnZoomOut.disabled = false;
      }
    });
  }

  function _open(event) {
    if (active || !event || !event.data || !event.data.img) {
      return;
    }

    eventData = event.data.img;

    document.documentElement.classList.add('s-fullscreenImage-active');
    triggerCustomEvent(document, 'body:lock', {
      breakpoints: 'all'
    });
    setFocusOnTarget(container);
    triggerCustomEvent(document, 'focus:trap', {
      element: container
    });

    if (event.data.img.iiifId && event.data.img.width && event.data.img.height) {
      container.classList.add('s-zoomable');
      imgWidth = parseInt(event.data.img.width);
      imgHeight = parseInt(event.data.img.height);
      _finishZoomOpen(event.data.img.iiifId);
    } else {
      container.classList.remove('s-zoomable');
      if (event.data.img.width !== 'auto' && event.data.img.height !== 'auto') {
        imgWidth = parseInt(event.data.img.width);
        imgHeight = parseInt(event.data.img.height);
        _finishNonZoomOpen();
      } else {
        imgWidth = 0;
        imgHeight = 0;
        $img.addEventListener('load', _finishNonZoomOpen, false);
        $img.setAttribute('srcset', eventData.srcset);
      }
    }

    $btnShare.setAttribute('data-share-url', eventData.shareUrl);
    $btnShare.setAttribute('data-share-title', eventData.shareTitle);

    active = true;
  }

  function _init() {
    $img = container.querySelector('.o-fullscreen-image__img');
    $osd = container.querySelector('.o-fullscreen-image__osd');
    $btnZoomIn = container.querySelector('[data-fullscreen-zoom-in]');
    $btnZoomOut = container.querySelector('[data-fullscreen-zoom-out]');
    $btnClose = container.querySelector('[data-fullscreen-close]');
    $btnShare = container.querySelector('[data-fullscreen-share]');

    $btnClose.addEventListener('click', _close, false);
    document.addEventListener('fullScreenImage:open', _open, false);
    document.addEventListener('fullScreenImage:close', _close, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    $btnClose.removeEventListener('click', _close);
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
