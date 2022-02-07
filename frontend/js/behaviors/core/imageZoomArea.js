import { setFocusOnTarget, triggerCustomEvent } from '@area17/a17-helpers';
import OpenSeadragon from '../../libs/openseadragon';

const imageZoomArea = function(container) {

  const maxZoomLevel = 3;
  const maxImgDim = 3000;

  let osd;
  let eventData = null;
  let active = false;

  let $btnPrev, $btnNext, $btnZoomIn, $btnZoomOut, $btnClose, $img, $osd, $linkInfo, $creditInfoTrigger, $creditInfoText;

  let prevItem = null;
  let nextItem = null;

  let imgWidth = 0;
  let imgHeight = 0;

  let fakeEvent = false;

  function _zoomIn(event) {
    event.preventDefault();
    $btnZoomIn.blur();
  }

  function _zoomOut(event) {
    event.preventDefault();
    $btnZoomOut.blur();
  }

  function _prev(event) {
    fakeEvent = true;
    _close();
    prevItem.click();
    fakeEvent = false;
  }

  function _next(event) {
    fakeEvent = true;
    _close();
    nextItem.click();
    fakeEvent = false;
  }

  function _close(event) {
    if (!active) {
      return;
    }

    if (!fakeEvent) {
      triggerCustomEvent(document, 'body:unlock');
      triggerCustomEvent(document, 'focus:untrap');
      document.documentElement.classList.remove('s-fullscreenImage-active');
      setTimeout(function(){ setFocusOnTarget(document.getElementById('a17')); }, 0)
      container.classList.remove('s-zoomable');
    }

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

    // WEB-2073: Work-around for wrong domain; wrong size?
    let tileSource = id.includes('osd=imgix') ? id : [
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
    ];

    osd = OpenSeadragon({
      id: "openseadragon",
      prefixUrl: location.protocol + "//openseadragon.github.io/openseadragon/images/",
      springStiffness: 15, // 6.5
      visibilityRatio: 1, // 0.5
      zoomPerClick: 1.3, // 2.0
      constrainDuringPan: true, // false
      animationTime: 1.5, // 1.2
      minZoomLevel: 0, // null
      maxZoomPixelRatio: 1.0, // 1.1
      gestureSettingsMouse: {
        scrollToZoom: true,
      },
      zoomInButton: "osd_zoomInButton",
      zoomOutButton: "osd_zoomOutButton",
      showZoomControl: true,
      showHomeControl: true,
      showFullPageControl: false,
      showRotationControl: false,
      showSequenceControl: false,
      tileSources: tileSource,
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

    if (!fakeEvent) {
      triggerCustomEvent(document, 'body:lock', {
        breakpoints: 'all'
      });
    }

    window.requestAnimationFrame(function(){

      if (!fakeEvent) {
        document.documentElement.classList.add('s-fullscreenImage-active');
        setTimeout(function(){ setFocusOnTarget(container); }, 0)
        triggerCustomEvent(document, 'focus:trap', {
          element: container
        });
      }

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

      if (eventData.credit) {
        $creditInfoText.innerHTML = eventData.credit;
        $creditInfoText.setAttribute('style', '');
        $creditInfoTrigger.setAttribute('style', '');
      } else {
        $creditInfoText.innerHTML = '';
        $creditInfoText.setAttribute('style', 'display: none');
        $creditInfoTrigger.setAttribute('style', 'display: none');
      }

      if (eventData.infoUrl && !eventData.enableNavigation) {
        $linkInfo.setAttribute('href', eventData.infoUrl);
        $linkInfo.setAttribute('style', '');
      } else {
        $linkInfo.setAttribute('href', 'javascript:;');
        $linkInfo.setAttribute('style', 'display: none');
      }

      if (eventData.enableNavigation) {
        $btnPrev.setAttribute('style', '');
        $btnNext.setAttribute('style', '');
      } else {
        $btnPrev.setAttribute('style', 'display: none');
        $btnNext.setAttribute('style', 'display: none');
      }

      if (eventData.prevItem) {
        prevItem = eventData.prevItem;
        $btnPrev.disabled = false;
      } else {
        prevItem = null;
        $btnPrev.disabled = true;
      }

      if (eventData.nextItem) {
        nextItem = eventData.nextItem;
        $btnNext.disabled = false;
      } else {
        nextItem = null;
        $btnNext.disabled = true;
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
    $btnPrev = container.querySelector('[data-fullscreen-prev]');
    $btnNext = container.querySelector('[data-fullscreen-next]');
    $btnZoomIn = container.querySelector('[data-fullscreen-zoom-in]');
    $btnZoomOut = container.querySelector('[data-fullscreen-zoom-out]');
    $btnClose = container.querySelector('[data-fullscreen-close]');
    $linkInfo = container.querySelector('.o-fullscreen-image__info-link');
    $creditInfoTrigger = container.querySelector('.m-info-trigger');
    $creditInfoText = container.querySelector('.m-info-trigger__info');

    $btnPrev.addEventListener('click', _prev, false);
    $btnNext.addEventListener('click', _next, false);
    $btnClose.addEventListener('click', _close, false);
    document.addEventListener('fullScreenImage:open', _open, false);
    document.addEventListener('fullScreenImage:close', _close, false);
    window.addEventListener('keyup', _escape, false);

    fakeEvent = false;
  }

  this.destroy = function() {
    // Remove specific event handlers
    $btnPrev.removeEventListener('click', _prev);
    $btnNext.removeEventListener('click', _next);
    $btnClose.removeEventListener('click', _close);
    document.removeEventListener('fullScreenImage:open', _open);
    document.removeEventListener('fullScreenImage:close', _close);
    window.removeEventListener('keyup', _escape);

    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);

    fakeEvent = false;
  };

  this.init = function() {
    _init();
  };
};

export default imageZoomArea;
