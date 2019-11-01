import { triggerCustomEvent, objectifyForm } from '@area17/a17-helpers';

const fixedOnScroll = function(container) {
  const getOffsetTop = element => {
    let offsetTop = 0;
    while(element) {
      offsetTop += element.offsetTop;
      element = element.offsetParent;
    }
    return offsetTop;
  }

  let $header = document.querySelector('header.g-header');
  let scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
  let containerHeight = container.offsetHeight;
  let containerTop = getOffsetTop(container) + document.body.scrollTop;
  let windowHeight = window.innerHeight || document.documentElement.clientHeight;
  let ticking = false;

  function update() {
    ticking = false;

    if(scrollTop > containerTop + containerHeight - windowHeight) {
      if(document.documentElement.classList.contains('is-module3d-fixed')) {
        document.documentElement.classList.remove('is-module3d-fixed');
      }
    } else if(scrollTop > containerTop) {
      if(!document.documentElement.classList.contains('is-module3d-fixed')) {
        document.documentElement.classList.add('is-module3d-fixed');
      }
    } else {
      if(document.documentElement.classList.contains('is-module3d-fixed')) {
        document.documentElement.classList.remove('is-module3d-fixed');
      }
    }
  }

  function requestTick() {
    if (!ticking) {
      requestAnimationFrame(update);
    }
    ticking = true;
  }

  function handleScroll() {
    scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
    requestTick();
  }

  function handleResizeAgain() {
    handleResize();
  }

  function handleResize() {
    windowHeight = window.innerHeight || document.documentElement.clientHeight;
    containerHeight = container.offsetHeight;
    containerTop = getOffsetTop(container) + document.body.scrollTop;
  }

  function _init() {
    window.addEventListener('scroll', handleScroll);
    window.addEventListener('resized', handleResize);
    document.addEventListener('module3d:loaded', handleResizeAgain);
    handleScroll();
  }

  this.destroy = function() {
    window.removeEventListener('resized', handleResize);
    window.removeEventListener('scroll', handleScroll);
    document.removeEventListener('module3d:loaded', handleResizeAgain);
    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default fixedOnScroll;
