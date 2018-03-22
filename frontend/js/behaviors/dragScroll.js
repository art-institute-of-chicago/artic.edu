// dragScroll

import { purgeProperties } from '@area17/a17-helpers';

const dragScroll = function(container) {

  let lastScrollLeft = 0;
  let lastClientX = 0;
  let dragging = false;
  let allowClicks = true;
  let xVelocity = 0;

  function updateScroll(x, y) {
    let newScrollLeft = lastScrollLeft - x;
    container.scrollLeft = newScrollLeft;
    lastScrollLeft = newScrollLeft;

    if( lastScrollLeft > 0){
      container.parentElement.classList.add('s-scroll-start');
    }else{
      container.parentElement.classList.remove('s-scroll-start');
    }

    if( container.clientWidth + newScrollLeft >= container.scrollWidth){
      container.parentElement.classList.add('s-scroll-end');
    }else{
      container.parentElement.classList.remove('s-scroll-end');
    }
  }

  function _momentum() {
    if (!dragging) {
      // if there is some velocity, shrink it, linear (no easing)
      if (Math.abs(xVelocity) > 0) {
        xVelocity = (xVelocity > 0) ? xVelocity - 1 : xVelocity + 1;
      }
      // if some momentum remains, update scroll and try again
      if (Math.abs(xVelocity) > 0) {
        updateScroll(xVelocity);
        window.requestAnimationFrame(_momentum);
      }
    }
  }

  function _clicks(event) {
    if (!allowClicks) {
      event.preventDefault();
      event.stopPropagation();
    }
  }

  function _mouseDown(event) {
    event.preventDefault();
    container.classList.add('s-mousedown');
    // reset everything
    xVelocity = 0;
    lastScrollLeft = container.scrollLeft;
    lastClientX = event.clientX;
    // allow mouse move tracking
    dragging = true;
  }

  function _mouseUp(event) {
    // stop mouse move tracking
    dragging = false;
    // if we have some velocity, do momentum
    if (Math.abs(xVelocity) > 0) {
      window.requestAnimationFrame(_momentum);
    }
    container.classList.remove('s-dragging');
    container.classList.remove('s-mousedown');
    setTimeout(function(){
      allowClicks = true;
    }, 50);
  }

  function _mouseMove(event) {
    if (dragging) {
      // get the distance moved
      xVelocity = -lastClientX + event.clientX;
      // update
      updateScroll(xVelocity);
      // set so we can compare
      lastClientX = event.clientX;
      // if it looks like the user is trying to scroll, block link clicks
      if (Math.abs(xVelocity) > 20) {
        allowClicks = false;
      }
      //
      container.classList.add('s-dragging');
    }
  }

  function _init() {
    container.addEventListener('click', _clicks, false);
    container.addEventListener('mousedown', _mouseDown, false);
    window.addEventListener('mouseup', _mouseUp, false);
    window.addEventListener('mousemove', _mouseMove, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    container.removeEventListener('click', _clicks);
    container.removeEventListener('mousedown', _mouseDown);
    window.removeEventListener('mouseup', _mouseUp);
    window.removeEventListener('mousemove', _mouseMove);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default dragScroll;
