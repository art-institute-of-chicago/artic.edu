import { purgeProperties, queryStringHandler, forEach, getUrlParameterByName } from 'a17-helpers';

const rangeSlider = function(container){

  // get range values
  const rangeValues = window[container.getAttribute('data-range-values')];

  if (!rangeValues) {
    return;
  }

  // objects
  const $slideTrack = container.querySelector('[data-range-slider]');
  const $min = container.querySelector('[data-range-thumb-min]');
  const $max = container.querySelector('[data-range-thumb-max]');
  const $range = container.querySelector('[data-range-bar]');
  const $minDisplay = container.querySelector('[data-range-min-display]');
  const $maxDisplay = container.querySelector('[data-range-max-display]');
  // get param to update
  const param = container.getAttribute('data-param');
  // defaults
  let maxIncrements = rangeValues.length;
  let minIncrementIndex = 0;
  let maxIncrementIndex = maxIncrements - 1;
  // what values does the range start on? these update as the sliders move
  let minThumbInitIncrementIndex = minIncrementIndex;
  let maxThumbInitIncrementIndex = maxIncrementIndex;
  // vars so we can convert the left positions to an increment index
  let singleIncrementSizeInPixels;
  // the left position of the thumbs
  let minThumbCurrentLeftPositionInPixels, maxThumbCurrentLeftPositionInPixels;
  // drag differences
  let xDown, xDiff, leftDragPosInit;
  // halt duplicate drags
  let dragging = false;
  // update timer to trigger page load when finished dragging around
  let draggingTimer;

  function _findInArray(array, value) {
    let returnIndex = -1;
    forEach(array, function(index, item) {
      if (item === value) {
        returnIndex = index;
      }
    });
    return returnIndex;
  }

  function _triggerPageLoad() {
    // todo: replace with ajax call
    var windowLocationHref = queryStringHandler.updateParameter(window.location.href, param+'-start', rangeValues[minThumbInitIncrementIndex]);
    windowLocationHref = queryStringHandler.updateParameter(windowLocationHref, param+'-end', rangeValues[maxThumbInitIncrementIndex]);
    //
    window.location.href = windowLocationHref;
  }

  function convertPixelsToIncrementIndex(left) {
    return Math.floor((left / $slideTrack.offsetWidth) * (maxIncrementIndex));
  }

  function convertIncrementIndexToPixels(index) {
    return Math.round(index * singleIncrementSizeInPixels);
  }

  function _checkOutOfBounds(left) {
    let isMinThumb = (dragging.getAttribute('data-range-thumb-min') !== null);

    if (isMinThumb) {
      if (left > maxThumbCurrentLeftPositionInPixels - singleIncrementSizeInPixels) {
        left = maxThumbCurrentLeftPositionInPixels - singleIncrementSizeInPixels;
      }
      if (left < 0) {
        left = 0;
      }
      minThumbCurrentLeftPositionInPixels = left;
      minThumbInitIncrementIndex = convertPixelsToIncrementIndex(minThumbCurrentLeftPositionInPixels);
    } else {
      let maxLeft = Math.floor(maxIncrementIndex * singleIncrementSizeInPixels);
      if (left > maxLeft) {
        left = maxLeft;
      }
      if (left < minThumbCurrentLeftPositionInPixels + singleIncrementSizeInPixels) {
        left = minThumbCurrentLeftPositionInPixels + singleIncrementSizeInPixels;
      }
      maxThumbCurrentLeftPositionInPixels = left;
      maxThumbInitIncrementIndex = convertPixelsToIncrementIndex(maxThumbCurrentLeftPositionInPixels);
    }
  }

  function _updateDisplay() {
    $min.style.left = minThumbCurrentLeftPositionInPixels + 'px';
    $max.style.left = maxThumbCurrentLeftPositionInPixels + 'px';
    $range.style.width = (maxThumbCurrentLeftPositionInPixels - minThumbCurrentLeftPositionInPixels) + 'px';
    $range.style.left = minThumbCurrentLeftPositionInPixels + 'px';
    if ($minDisplay && $maxDisplay) {
      $minDisplay.textContent = rangeValues[minThumbInitIncrementIndex];
      $maxDisplay.textContent = rangeValues[maxThumbInitIncrementIndex];
    }
  }

  function _calcValues(){
    singleIncrementSizeInPixels = $slideTrack.offsetWidth / maxIncrementIndex;
    //
    minThumbCurrentLeftPositionInPixels = convertIncrementIndexToPixels(minThumbInitIncrementIndex);
    maxThumbCurrentLeftPositionInPixels = convertIncrementIndexToPixels(maxThumbInitIncrementIndex);
    //
    _updateDisplay();
  }

  function _onDraggingStart(event) {
    if (!dragging) {
      dragging = event.target;
      leftDragPosInit = parseInt(event.target.style.left);
      dragging.classList.add('s-dragging');
      container.classList.add('s-dragging');
      try {
        clearTimeout(draggingTimer);
      } catch(err) {}
    }
  }

  function _onDragging(event, xNow) {
    if (dragging) {
      if (!xDown) {
        return;
      }
      // diffs
      xDiff = xDown - xNow;
      // new values
      let leftDragPos = leftDragPosInit - xDiff;
      // stop dragging off the screen
      leftDragPos = _checkOutOfBounds(leftDragPos);
      // update position
      _updateDisplay();
    }
  }

  function _onDraggingEnd(event) {
    if (dragging) {
      dragging.classList.remove('s-dragging');
      container.classList.remove('s-dragging');
      dragging = false;
      // reset
      xDown = undefined;
      xDiff = undefined;
      //
      draggingTimer = setTimeout(_triggerPageLoad, 500);
    }
  }

  function _setUpDragging(el) {
    // dragging
    el.addEventListener('mousedown', function(event){
      event.preventDefault();
      if (event.which === 1) {
        xDown = event.pageX;
        _onDraggingStart(event);
      }
    }, false);

    document.addEventListener('mousemove', function(event){
      _onDragging(event, event.pageX);
    }, false);

    document.addEventListener('mouseup', function(event){
      _onDraggingEnd(event);
    }, false);

    // touch versions
    el.addEventListener('touchstart', function(event){
      event.preventDefault();
      event.stopPropagation();
      xDown = event.touches[0].clientX;
      _onDraggingStart(event);
    }, false);

    document.addEventListener('touchmove', function(event){
      event.preventDefault();
      event.stopPropagation();
      _onDragging(event, event.changedTouches[0].clientX);
    }, false);

    document.addEventListener('touchend', function(event){
      _onDraggingEnd(event);
    }, false);
  }

  function _init() {
    // grab init positions from URL
    let initStart = getUrlParameterByName(param+'-start', window.location.search);
    let initEnd = getUrlParameterByName(param+'-end', window.location.search);
    if (initStart) {
      minThumbInitIncrementIndex = _findInArray(rangeValues, initStart) || minIncrementIndex;
    }
    if (initEnd) {
      maxThumbInitIncrementIndex = _findInArray(rangeValues, initEnd) || maxIncrementIndex;
    }

    // set up dragging
    _setUpDragging($min);
    _setUpDragging($max);

    // go go go
    document.addEventListener('resized', _calcValues, false);
    _calcValues();
  }

  this.destroy = function() {
    // remove specific event handlers
    document.removeEventListener('resized', _calcValues);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default rangeSlider;
