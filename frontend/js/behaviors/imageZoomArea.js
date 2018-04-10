import { purgeProperties, setFocusOnTarget, forEach, getIndex, triggerCustomEvent } from '@area17/a17-helpers';
import { focusTrap } from '../functions';

const imageZoomArea = function(container) {

  const maxZoomLevel = 3;
  const maxImgDim = 3000;

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

  let leftDragPos = -50;
  let topDragPos = -50;
  let maxMovementW = 0;
  let maxMovementH = 0;

  let xDown, yDown, xDiff, yDiff, leftDragPosInit, topDragPosInit;
  let dragging = false;

  function _checkOutOfBounds() {
    // max movement in px
    maxMovementW = (imgWidth - containerDims[0]) / 2;
    maxMovementH = (imgHeight - containerDims[1]) / 2;
    // covert to % of img
    maxMovementW = (maxMovementW / initImgWidth) * 100;
    maxMovementH = (maxMovementH / initImgHeight) * 100;
    // set max/mins
    let maxDragLeft = -50 + maxMovementW;
    let minDragLeft = -50 - maxMovementW;
    let maxDragTop = -50 + maxMovementH;
    let minDragTop = -50 - maxMovementH;
    // restrict
    if (maxMovementW > 0) {
      leftDragPos = leftDragPos > maxDragLeft ? maxDragLeft : leftDragPos;
      leftDragPos = leftDragPos < minDragLeft ? minDragLeft : leftDragPos;
    } else {
      leftDragPos = -50;
    }
    if (maxMovementH > 0) {
      topDragPos = topDragPos > maxDragTop ? maxDragTop : topDragPos;
      topDragPos = topDragPos < minDragTop ? minDragTop : topDragPos;
    } else {
      topDragPos = -50;
    }
  }

  function _position() {
    img.style['-webkit-transform'] = 'translate(' + leftDragPos + '%, ' + topDragPos + '%) scale('+zoomFactor+')';
    img.style['-moz-transform'] = 'translate(' + leftDragPos + '%, ' + topDragPos + '%) scale('+zoomFactor+')';
    img.style['-ms-transform'] = 'translate(' + leftDragPos + '%, ' + topDragPos + '%) scale('+zoomFactor+')';
    img.style.transform = 'translate(' + leftDragPos + '%, ' + topDragPos + '%) scale('+zoomFactor+')';
  }

  function _onDraggingStart() {
    if (!dragging && currentZoomLevel > 0) {
      dragging = true;
      leftDragPosInit = leftDragPos;
      topDragPosInit = topDragPos;
      img.classList.add('s-dragging');
    }
  }

  function _onDragging(event, xNow, yNow) {
    if (dragging && currentZoomLevel > 0) {
      if (!xDown || !yDown) {
        return;
      }
      // img dims
      let imgW = initImgWidth * zoomFactor;
      let imgH = initImgHeight * zoomFactor;
      // diffs
      xDiff = xDown - xNow;
      yDiff = yDown - yNow;
      // new values
      leftDragPos = leftDragPosInit - ((xDiff / imgWidth) * 100);
      topDragPos = topDragPosInit - ((yDiff / imgHeight) * 100);
      // stop dragging off the screen
      _checkOutOfBounds();
      // update position
      _position();
    }
  }

  function _onDraggingEnd() {
    if (dragging) {
      dragging = false;
      img.classList.remove('s-dragging');
      // reset
      xDown = undefined;
      yDown = undefined;
      xDiff = undefined;
      yDiff = undefined;
    }
  }

  function _setUpDragging() {
    // dragging
    img.addEventListener('mousedown', function(event){
      event.preventDefault();
      if (event.which === 1 && currentZoomLevel > 0) {
        xDown = event.pageX;
        yDown = event.pageY;
        _onDraggingStart();
      }
    }, false);

    img.addEventListener('mousemove', function(event){
      if (currentZoomLevel > 0) {
        _onDragging(
          event,
          event.pageX,
          event.pageY
        );
      }
    }, false);

    img.addEventListener('mouseup', function(event){
      if (currentZoomLevel > 0) {
        _onDraggingEnd(event);
      }
    }, false);

    // touch versions
    img.addEventListener('touchstart', function(event){
      if (currentZoomLevel > 0) {
        event.preventDefault();
        event.stopPropagation();
        xDown = event.touches[0].clientX;
        yDown = event.touches[0].clientY;
        _onDraggingStart();
      }
    }, false);

    img.addEventListener('touchmove', function(event){
      if (currentZoomLevel > 0) {
        event.preventDefault();
        event.stopPropagation();
        _onDragging(event,event.changedTouches[0].clientX, event.changedTouches[0].clientY);
      }
    }, false);

    img.addEventListener('touchend', function(event){
      if (currentZoomLevel > 0) {
        _onDraggingEnd(event);
      }
    }, false);
  }

  function _bestFit() {
    containerDims = [];
    containerDims.push(container.offsetWidth);
    containerDims.push(container.offsetHeight);
    containerDims.push(containerDims[1]/containerDims[0]);

    imgDims = [];
    imgDims.push(initImgWidth);
    imgDims.push(initImgHeight);
    imgDims.push(imgDims[1]/imgDims[0]);

    if (imgDims[2] === containerDims[2]) {
      imgDims[0] = Math.min.apply(null, [containerDims[0], containerDims[1]]);
      imgDims[1] = Math.min.apply(null, [containerDims[0], containerDims[1]]);
    } else if (imgDims[2] > containerDims[2]) {
      imgDims[0] = Math.round((imgDims[0]/imgDims[1]) * containerDims[1]);
      imgDims[1] = containerDims[1];
    } else {
      imgDims[1] = Math.round((imgDims[1]/imgDims[0]) * containerDims[0]);
      imgDims[0] = containerDims[0];
    }

    zoomFactor = imgDims[0] / initImgWidth;
    initZoomFactor = zoomFactor;

    _checkOutOfBounds();
    _position();
  }

  function _updateZoom() {
    if (currentZoomLevel === maxZoomLevel) {
      zoomFactor = 1;
    } else if (currentZoomLevel === 0) {
      zoomFactor = initZoomFactor;
    } else {
      zoomFactor = (((1 - initZoomFactor) / maxZoomLevel) * currentZoomLevel) + initZoomFactor;
    }

    imgWidth = initImgWidth * zoomFactor;
    imgHeight = initImgHeight * zoomFactor;
  }

  function _zoomIn(event) {
    event.preventDefault();
    btnZoomIn.blur();
    currentZoomLevel = currentZoomLevel + 1;
    if (currentZoomLevel === maxZoomLevel) {
      btnZoomIn.disabled = true;
      btnZoomOut.disabled = false;
    } else {
      btnZoomIn.disabled = false;
      btnZoomOut.disabled = false;
    }
    _updateZoom();
    _checkOutOfBounds();
    _position();
    img.classList.add('s-draggable');
  }

  function _zoomOut(event) {
    event.preventDefault();
    btnZoomOut.blur();
    currentZoomLevel = currentZoomLevel - 1;
    if (currentZoomLevel === 0) {
      btnZoomIn.disabled = false;
      btnZoomOut.disabled = true;
      img.classList.remove('s-draggable');
    } else {
      btnZoomIn.disabled = false;
      btnZoomOut.disabled = false;
    }
    _updateZoom();
    _checkOutOfBounds();
    _position();
  }

  function _handleResized() {
    currentZoomLevel = 0;
    zoomFactor = 0;
    initZoomFactor = 0;
    btnZoomIn.disabled = false;
    btnZoomOut.disabled = true;
    img.classList.remove('s-draggable');
    leftDragPos = -50;
    topDragPos = -50;
    _bestFit();
  }

  function _close(event) {
    if (!active) {
      return;
    }
    document.documentElement.classList.remove('s-fullscreenImage-active');
    triggerCustomEvent(document, 'body:unlock');
    triggerCustomEvent(document, 'focus:untrap');
    setFocusOnTarget(document.getElementById('a17'));
    img.removeAttribute('width');
    img.removeAttribute('height');
    img.removeAttribute('srcset');
    active = false;
  }

  function _open(event) {
    if (active || !event || !event.data || !event.data.img) {
      return;
    }

    document.documentElement.classList.add('s-fullscreenImage-active');
    triggerCustomEvent(document, 'body:lock', {
      breakpoints: 'all'
    });
    setFocusOnTarget(container);
    triggerCustomEvent(document, 'focus:trap', {
      element: container
    });

    initImgWidth = parseInt(event.data.img.width);
    initImgHeight = parseInt(event.data.img.height);

    // for for if the image is smaller than the max dimension
    if (initImgWidth < maxImgDim && initImgHeight < maxImgDim) {
      if (initImgWidth === initImgHeight) {
        initImgWidth = maxImgDim;
        initImgHeight = maxImgDim;
      } else if (initImgWidth > initImgHeight) {
        initImgHeight = Math.round((initImgHeight/initImgWidth) * maxImgDim);
        initImgWidth = maxImgDim;
      } else {
        initImgWidth = Math.round((initImgWidth/initImgHeight) * maxImgDim);
        initImgHeight = maxImgDim;
      }
    }

    // trap for too large images
    if (initImgWidth > maxImgDim || initImgHeight > maxImgDim) {
      if (initImgWidth === initImgHeight) {
        initImgWidth = maxImgDim;
        initImgHeight = maxImgDim;
      } else if (initImgWidth > initImgHeight) {
        initImgHeight = Math.round((initImgHeight/initImgWidth) * maxImgDim);
        initImgWidth = maxImgDim;
      } else {
        initImgWidth = Math.round((initImgWidth/initImgHeight) * maxImgDim);
        initImgHeight = maxImgDim;
      }
    }

    img.setAttribute('width', initImgWidth);
    img.setAttribute('height', initImgHeight);
    img.setAttribute('src', event.data.img.src);
    img.setAttribute('srcset', event.data.img.srcset);

    btnShare.setAttribute('data-share-url', event.data.img.shareUrl);
    btnShare.setAttribute('data-share-title', event.data.img.shareTitle);

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

    _setUpDragging();
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
