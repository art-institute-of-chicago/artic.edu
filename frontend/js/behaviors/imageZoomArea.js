import { purgeProperties, setFocusOnTarget, forEach, getIndex, triggerCustomEvent } from '@area17/a17-helpers';
import { focusTrap } from '../functions';

const imageZoomArea = function(container) {

  const maxZoomLevel = 3;
  const maxImgDim = 3000;

  let osd;
  let eventData = null;
  let active = false;

  let $btnZoomIn, $btnZoomOut, $btnClose, $img, $osd, $linkInfo;

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
    triggerCustomEvent(document, 'body:unlock');
    triggerCustomEvent(document, 'focus:untrap');
    document.documentElement.classList.remove('s-fullscreenImage-active');
    setTimeout(function(){ setFocusOnTarget(document.getElementById('a17')); }, 0)
    container.classList.remove('s-zoomable');
    $img.removeAttribute('width');
    $img.removeAttribute('height');
    $img.removeAttribute('srcset');
    $img.removeAttribute('sizes');
    $img.removeAttribute('src');
    $img.classList.remove('restrict');
    $img.removeEventListener('contextmenu', preventDefault);
    $img.removeEventListener('mousedown', preventDefault);
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
    if (eventData.restrict) {
      $img.setAttribute('class', 'restrict');
      $img.addEventListener('contextmenu', preventDefault);
      $img.addEventListener('mousedown', preventDefault);
    }

    if (window.picturefill) {
      window.picturefill($img);
    }
  }

  function preventDefault(e) {
    e.preventDefault();
  }

  function _finishZoomOpen(id) {

    osd = OpenSeadragon({
      id: "openseadragon",
      prefixUrl: location.protocol + "//openseadragon.github.io/openseadragon/images/",
      preserveViewport: true,
      springStiffness: 15,
      visibilityRatio: 1,
      zoomPerScroll: 1.2,
      zoomPerClick: 1.3,
      immediateRender:false,
      constrainDuringPan: true,
      animationTime: 1.5,
      minZoomLevel: 0,
      minZoomImageRatio: 0.8,
      maxZoomPixelRatio: 1.0,
      defaultZoomLevel: 0,
      gestureSettingsMouse: {
        scrollToZoom: true
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
          "@context": "http://iiif.io/api/image/2/context.json",
          "@id": id,
          "width": imgWidth,
          "height": imgHeight,
          "profile": [ "http://iiif.io/api/image/2/level2.json" ],
          "protocol": "http://iiif.io/api/image",
          "tiles": [{
            "scaleFactors": [ 1, 2, 4, 8, 16 ],
            "width": 256
          }]
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
        triggerCustomEvent(document, 'gtm:push', {
          'event': 'artwork-terminal-zoom',
          'eventCategory': 'in-page',
        });
      } else {
        $btnZoomIn.disabled = false;
        $btnZoomOut.disabled = false;
        triggerCustomEvent(document, 'gtm:push', {
          'event': 'artwork-zoom',
          'eventCategory': 'in-page',
        });
      }
    });
  }

  function _open(event) {
    if (active || !event || !event.data || !event.data.img) {
      return;
    }

    eventData = event.data.img;

    triggerCustomEvent(document, 'body:lock', {
      breakpoints: 'all'
    });

    window.requestAnimationFrame(function(){
      document.documentElement.classList.add('s-fullscreenImage-active');
      setTimeout(function(){ setFocusOnTarget(container); }, 0)
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

      if (eventData.infoUrl) {
        $linkInfo.setAttribute('href', eventData.infoUrl)
        $linkInfo.setAttribute('style', '')
      } else {
        $linkInfo.setAttribute('href', 'javascript:;');
        $linkInfo.setAttribute('style', 'display: none');
      }

      active = true;
    });
  }

  function _escape(event) {
    if (active && event.keyCode === 27) {
      triggerCustomEvent(document, 'fullScreenImage:close');
    }
  }

  function _init() {
    $img = container.querySelector('.o-fullscreen-image__img');
    $osd = container.querySelector('.o-fullscreen-image__osd');
    $btnZoomIn = container.querySelector('[data-fullscreen-zoom-in]');
    $btnZoomOut = container.querySelector('[data-fullscreen-zoom-out]');
    $btnClose = container.querySelector('[data-fullscreen-close]');
    $linkInfo = container.querySelector('.o-fullscreen-image__info');

    $btnClose.addEventListener('click', _close, false);
    document.addEventListener('fullScreenImage:open', _open, false);
    document.addEventListener('fullScreenImage:close', _close, false);
    window.addEventListener('keyup', _escape, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    $btnClose.removeEventListener('click', _close);
    document.removeEventListener('fullScreenImage:open', _open);
    document.removeEventListener('fullScreenImage:close', _close);
    window.removeEventListener('keyup', _escape);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default imageZoomArea;
