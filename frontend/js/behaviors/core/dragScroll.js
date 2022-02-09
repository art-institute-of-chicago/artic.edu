const dragScroll = function(container) {

  let lastScrollLeft = 0;
  let lastClientX = 0;
  let dragging = false;
  let allowClicks = true;
  let xVelocity = 0;
  let allow = false;
  let allowedOnce = false;
  let scrollPositionCheck = null;
  let imgChildEls = [];
  let prevBtnEl;
  let nextBtnEl;

  const percentOfContainerToScrollPerClick = 0.5;

  function _wideEnoughToScroll() {
    allow = allowedOnce || container.scrollWidth > container.clientWidth;
    if (allow) {
      container.classList.add('s-scrollable');

      if (prevBtnEl) {
        prevBtnEl.classList.remove('s-hidden');
      }

      if (nextBtnEl) {
        nextBtnEl.classList.remove('s-hidden');
      }

      allowedOnce = true;
    } else {
      container.classList.remove('s-scrollable');
      container.classList.remove('s-dragging');
      container.classList.remove('s-mousedown');
      container.parentElement.classList.remove('s-scroll-start');
      container.parentElement.classList.remove('s-scroll-end');

      if (prevBtnEl) {
        prevBtnEl.classList.add('s-hidden');
      }

      if (nextBtnEl) {
        nextBtnEl.classList.add('s-hidden');
      }
    }

    scrollPositionCheck = null;
    _scroll();
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
      // If there is some velocity, shrink it, linear (no easing)
      if (Math.abs(xVelocity) > 0) {
        xVelocity = (xVelocity > 0) ? xVelocity - 1 : xVelocity + 1;
      }
      // If some momentum remains, update scroll and try again
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
      // Reset everything
      xVelocity = 0;
      lastScrollLeft = container.scrollLeft;
      lastClientX = event.clientX;
      // Allow mouse move tracking
      dragging = true;
    }
  }

  function _mouseUp(event) {
    if (allow) {
      // Stop mouse move tracking
      dragging = false;
      // If we have some velocity, do momentum
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
      // Get the distance moved
      xVelocity = -lastClientX + event.clientX;
      // Update
      _updateScroll(xVelocity);
      // Set so we can compare
      lastClientX = event.clientX;
      // If it looks like the user is trying to scroll, block link clicks
      if (Math.abs(xVelocity) > 3) {
        allowClicks = false;
      } else {
        allowClicks = true;
      }

      container.classList.add('s-dragging');
    }
  }

  function _scroll() {
    lastScrollLeft = container.scrollLeft;

    if (lastScrollLeft !== scrollPositionCheck) {
      scrollPositionCheck = lastScrollLeft;

      if (lastScrollLeft > 0) {
        // More accurately, it's actually `s-scroll-start[ed]`
        container.parentElement.classList.add('s-scroll-start');
        if (prevBtnEl) {
          prevBtnEl.disabled = false;
        }
      } else {
        container.parentElement.classList.remove('s-scroll-start');
        if (prevBtnEl) {
          prevBtnEl.disabled = true;
        }
      }

      if (container.clientWidth + lastScrollLeft >= container.scrollWidth){
        container.parentElement.classList.add('s-scroll-end');
        if (nextBtnEl) {
          nextBtnEl.disabled = true;
        }
      } else {
        container.parentElement.classList.remove('s-scroll-end');
        if (nextBtnEl) {
          nextBtnEl.disabled = false;
        }
      }
    }
  }

  function _scrollPrev(event) {
    container.scrollTo({
      top: 0,
      left: Math.max(container.scrollLeft - container.clientWidth * percentOfContainerToScrollPerClick, 0),
      behavior: 'smooth',
    });
  }

  function _scrollNext(event) {
    container.scrollTo({
      top: 0,
      left: Math.min(container.scrollLeft + container.clientWidth * percentOfContainerToScrollPerClick, container.scrollWidth),
      behavior: 'smooth',
    });
  }

  function _init() {
    container.addEventListener('click', _clicks, false);
    container.addEventListener('mousedown', _mouseDown, false);
    container.addEventListener('scroll', _scroll, false);
    window.addEventListener('mouseup', _mouseUp, false);
    window.addEventListener('mousemove', _mouseMove, false);
    window.addEventListener('resized', _wideEnoughToScroll, false);

    // @see `lazyLoad` in @area17/a17-helpers
    imgChildEls = container.querySelectorAll('img,iframe');

    for (let i = 0; i < imgChildEls.length; i++) {
      imgChildEls[i].addEventListener('load', _wideEnoughToScroll, false);
    }

    // WEB-1294: For scrolling slider image galleries
    let commonParent = container.parentNode;

    if (commonParent) {
      commonParent = commonParent.parentNode;
    }

    if (commonParent) {
      prevBtnEl = commonParent.querySelector('.b-drag-scroll__btn-prev');
      nextBtnEl = commonParent.querySelector('.b-drag-scroll__btn-next');
    }

    if (prevBtnEl) {
      prevBtnEl.addEventListener('click', _scrollPrev, false);
    }

    if (nextBtnEl) {
      nextBtnEl.addEventListener('click', _scrollNext, false);
    }

    _wideEnoughToScroll();
  }

  this.destroy = function() {
    // Remove specific event handlers
    container.removeEventListener('click', _clicks);
    container.removeEventListener('mousedown', _mouseDown);
    container.removeEventListener('scroll', _scroll);
    window.removeEventListener('mouseup', _mouseUp);
    window.removeEventListener('mousemove', _mouseMove);
    window.removeEventListener('resized', _wideEnoughToScroll);

    for (let i = 0; i < imgChildEls.length; i++) {
      imgChildEls[i].removeEventListener('load', _wideEnoughToScroll);
    }

    prevBtnEl.removeEventListener('click', _scrollPrev);
    nextBtnEl.removeEventListener('click', _scrollNext);

    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default dragScroll;
