import { purgeProperties, getOffset } from '@area17/a17-helpers';
import { mediaQuery } from '../functions';

const stickySidebar = function(container){

  const getOffsetTop = element => {
    let offsetTop = 0;
    while(element) {
      offsetTop += element.offsetTop;
      element = element.offsetParent;
    }
    return offsetTop;
  }

  let stopper = document.querySelector('.o-article');
  let stickyOffset = parseInt(container.getAttribute('data-sticky-offset'), 10);

  let scrollTop;

  let windowHeight;
  let containerHeight;
  let containerTop;
  let stopperOffset;

  function update() {
    if(scrollTop > containerTop - stickyOffset) {
      sticky();
    } else {
      unsticky();
    }
  }

  function sticky() {
    if(document.documentElement.classList.contains('is-sidebar-top')) {
      document.documentElement.classList.remove('is-sidebar-top');
    }
    if(!document.documentElement.classList.contains('is-sidebar-fixed')) {
      document.documentElement.classList.add('is-sidebar-fixed');
    }
    let offsetTop = (stickyOffset - Math.max(0, scrollTop + containerHeight + stickyOffset - stopperOffset));
    container.setAttribute('style','top:' + offsetTop + 'px');
  }

  function unsticky() {
    if(document.documentElement.classList.contains('is-sidebar-top')) {
      document.documentElement.classList.remove('is-sidebar-top');
    }
    if(document.documentElement.classList.contains('is-sidebar-fixed')) {
      document.documentElement.classList.remove('is-sidebar-fixed');
    }
    container.removeAttribute('style');
  }

  function handleScroll() {
    scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
    stopperOffset = getOffsetTop(stopper) + document.body.scrollTop + stopper.offsetHeight;
    update();
  }

  function handleResize() {
    unsticky();
    windowHeight = window.innerHeight || document.documentElement.clientHeight;
    containerHeight = container.offsetHeight;
    containerTop = getOffsetTop(container) + document.body.scrollTop;
    handleScroll();
  }

  function _init() {
    window.addEventListener('scroll', handleScroll);
    window.addEventListener('resized', handleResize);
    handleResize();
    handleScroll();
  }

  this.destroy = function() {
    window.removeEventListener('resized', handleResize);
    window.removeEventListener('scroll', handleScroll);
    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default stickySidebar;
