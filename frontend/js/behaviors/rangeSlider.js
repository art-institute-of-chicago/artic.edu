import { purgeProperties } from 'a17-helpers';

const rangeSlider = function(container){

  // objects
  var $slideTrack = $(".range-slider",container);
  var $min = $(".thumb--min",container);
  var $max = $(".thumb--max",container);
  var $range = $(".range-slider__range",container);
  var $minDisplay = $("[data-min-val-target]",container);
  var $maxDisplay = $("[data-max-val-target]",container);

  // defaults
  var rangeMin = parseInt(container.getAttribute("data-min")) || 0;
  var rangeMax = parseInt(container.getAttribute("data-max"));
  var increment = parseInt(container.getAttribute("data-increment")) || 0;
  var min = parseInt(container.getAttribute("data-min-default"));
  var max = parseInt(container.getAttribute("data-max-default"));
  var prefix = container.getAttribute("data-prefix");
  var suffix = container.getAttribute("data-suffix");
  var param = container.getAttribute("data-param");

  // values will be filled in by calcValues();
  var trackWidth, singleIncrement, minLeftPos, maxLeftPos;

  // lets update the display
  updateDisplay();
  $(document).on('resized',updateDisplay);

  // set up dragging
  $min.on("mousedown",setupDrag);
  $max.on("mousedown",setupDrag);
  $min.on("touchstart",setupDrag);
  $max.on("touchstart",setupDrag);

  //
  function setupDrag(event) {
    var $thumb = $(this);
    var thumbName = $thumb.attr("data-thumb");
    var isMin = (thumbName === "min");
    var isTouch = (event.type === "touchstart");
    // initial positions
    var currentPos = (isTouch) ? event.touches[0].clientX : getMouseX(event);
    var currentLeftPos = (isMin) ? minLeftPos : maxLeftPos;
    // change cursor
    $thumb.addClass("thumb--dragging");
    // moving
    $(document).on("mousemove",dragging);
    $(document).on("touchmove",dragging);
    // finished
    $(document).on("mouseup",dragend);
    $(document).on("touchend",dragend);
    //
    function dragging(event){
      // figure out new positions
      var newPos = (isTouch) ? event.touches[0].clientX : getMouseX(event);
      var newLeft = currentLeftPos - (currentPos - newPos);
      // normalize out of bounds
      if (isMin) {
        newLeft = (newLeft >= maxLeftPos) ? maxLeftPos : newLeft;
      } else {
        newLeft = (newLeft <= minLeftPos) ? minLeftPos : newLeft;
      }
      newLeft = (newLeft < 0) ? 0 : newLeft;
      newLeft = (newLeft > trackWidth) ? trackWidth : newLeft;
      // work out new value and update position vars
      if (isMin) {
        min = roundNum(minLeftPos/singleIncrement);
        minLeftPos = newLeft;
      } else {
        max = roundNum(maxLeftPos/singleIncrement);
        maxLeftPos = newLeft;
      }
      // update display
      setPositions();
      updateDisplayValues();
    }
    function dragend(){
      // tell page
      $(document).trigger("range_update",{
        param: param,
        min: min,
        max: max
      });
      // stop watching for movement
      $(this).off("mousemove");
      $(this).off("mouseup");
      $(this).off("touchmove");
      $(this).off("touchend");
      // reset cursor
      $thumb.removeClass("thumb--dragging");
    }
  }

  // where should the thumbs live based on the values?
  function calcValues(){
    trackWidth = parseInt($slideTrack.css("width"));
    singleIncrement = trackWidth / (rangeMax - rangeMin);
    minLeftPos = Math.floor(min*singleIncrement);
    maxLeftPos = Math.floor(max*singleIncrement);
  }
  // normalise returning of mouse position
  function getMouseX(event) {
    return (document.all) ? window.event.clientX : event.pageX;
  }
  // round to the nearest increment value
  function roundNum(num) {
    if (increment > 0) {
      return Math.round(num/increment) * increment;
    }
    return Math.round(num);
  }
  // update the thumbs/range display
  function setPositions() {
    $min.css("left", minLeftPos + "px");
    $max.css("left", maxLeftPos + "px");
    $range.css({
      width: (maxLeftPos - minLeftPos) + "px",
      left: minLeftPos + "px"
    });
  }
  // update the displayed values
  function updateDisplayValues() {
    if ($minDisplay && $maxDisplay) {
      var top = (max === rangeMax) ? "+" : "";
      $minDisplay[0].textContent = prefix + min + suffix;
      $maxDisplay[0].textContent = prefix + max + suffix + top;
    }
  }
  // update the visible components
  function updateDisplay() {
    calcValues();
    setPositions();
    updateDisplayValues();
  }

  function _init() {
    //input.addEventListener('input', _whittleDown, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    //input.removeEventListener('input', _whittleDown);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default rangeSlider;
