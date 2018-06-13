import { purgeProperties } from '@area17/a17-helpers';

const dragScroll = function(container) {

  let lastScrollLeft = 0;
  let lastClientX = 0;
  let dragging = false;
  let allowClicks = true;
  let xVelocity = 0;
  let allow = false;
  let scrollPositionCheck = 0;

  function _wideEnoughToScroll() {
    allow = container.scrollWidth > container.clientWidth;
    if (allow) {
      container.classList.add('s-scrollable');
    } else {
      container.classList.remove('s-scrollable');
      container.classList.remove('s-dragging');
      container.classList.remove('s-mousedown');
      container.parentElement.classList.remove('s-scroll-start');
      container.parentElement.classList.remove('s-scroll-end');
    }
  }

  function _updateScroll(x, y) {
    if (allow) {
      let newScrollLeft = lastScrollLeft - x;
      container.scrollLeft = newScrollLeft;
      lastScrollLeft = newScrollLeft;
    }
  }

  function _momentum() {
    if (allow && !dragging) {
      // if there is some velocity, shrink it, linear (no easing)
      if (Math.abs(xVelocity) > 0) {
        xVelocity = (xVelocity > 0) ? xVelocity - 1 : xVelocity + 1;
      }
      // if some momentum remains, update scroll and try again
      if (Math.abs(xVelocity) > 0) {
        _updateScroll(xVelocity);
        window.requestAnimationFrame(_momentum);
      }
    }
  }

  function _clicks(event) {
    if (allow && !allowClicks) {
      event.preventDefault();
      event.stopPropagation();
    }
  }

  function _mouseDown(event) {
    if (allow) {
      event.preventDefault();
      container.classList.add('s-mousedown');
      // reset everything
      xVelocity = 0;
      lastScrollLeft = container.scrollLeft;
      lastClientX = event.clientX;
      // allow mouse move tracking
      dragging = true;
    }
  }

  function _mouseUp(event) {
    if (allow) {
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
  }

  function _mouseMove(event) {
    if (allow && dragging) {
      // get the distance moved
      xVelocity = -lastClientX + event.clientX;
      // update
      _updateScroll(xVelocity);
      // set so we can compare
      lastClientX = event.clientX;
      // if it looks like the user is trying to scroll, block link clicks
      if (Math.abs(xVelocity) > 3) {
        allowClicks = false;
      } else {
        allowClicks = true;
      }
      //
      container.classList.add('s-dragging');
    }
  }

  function _scroll() {
    lastScrollLeft = container.scrollLeft;

    if (lastScrollLeft !== scrollPositionCheck) {
      scrollPositionCheck = lastScrollLeft;

      if (lastScrollLeft > 0) {
        container.parentElement.classList.add('s-scroll-start');
      } else {
        container.parentElement.classList.remove('s-scroll-start');
      }

      if (container.clientWidth + lastScrollLeft >= container.scrollWidth){
        container.parentElement.classList.add('s-scroll-end');
      } else {
        container.parentElement.classList.remove('s-scroll-end');
      }
    }
  }

  function _init() {
    container.addEventListener('click', _clicks, false);
    container.addEventListener('mousedown', _mouseDown, false);
    container.addEventListener('scroll', _scroll, false);
    window.addEventListener('mouseup', _mouseUp, false);
    window.addEventListener('mousemove', _mouseMove, false);
    window.addEventListener('resized', _wideEnoughToScroll, false);

    _wideEnoughToScroll();
  }

  this.destroy = function() {
    // remove specific event handlers
    container.removeEventListener('click', _clicks);
    container.removeEventListener('mousedown', _mouseDown);
    container.removeEventListener('scroll', _scroll);
    window.removeEventListener('mouseup', _mouseUp);
    window.removeEventListener('mousemove', _mouseMove);
    window.removeEventListener('resized', _wideEnoughToScroll);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default dragScroll;
