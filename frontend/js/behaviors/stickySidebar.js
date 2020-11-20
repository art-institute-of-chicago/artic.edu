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

  const setState = targetState => {
    let classList = document.documentElement.classList;

    ['is-sidebar-top', 'is-sidebar-fixed', 'is-sidebar-bottom'].forEach(state => {
      if (state !== targetState && classList.contains(state)) {
        classList.remove(state);
      }
    });

    if (!classList.contains(targetState)) {
      classList.add(targetState);
    }
  }

  let article = document.querySelector('.o-article');

  let stickyOffset = parseInt(container.getAttribute('data-sticky-offset'), 10);
  container.setAttribute('style', 'padding-top:' + stickyOffset + 'px');

  let scrollTop;

  let windowHeight;
  let containerTop;
  let containerBottom;
  let containerHeight;

  function update() {
    scrollTop = document.documentElement.scrollTop || document.body.scrollTop;

    if (scrollTop < containerTop) {
      top();
    } else {
      containerHeight = container.offsetHeight;
      containerBottom = getOffsetTop(article) + document.body.scrollTop + article.offsetHeight;

      if (scrollTop + containerHeight > containerBottom) {
        bottom();
      } else {
        sticky();
      }
    }
  }

  function top() {
    setState('is-sidebar-top');
  }

  function sticky() {
    setState('is-sidebar-fixed');
  }

  function bottom() {
    setState('is-sidebar-bottom');
  }

  function handleScroll() {
    window.requestAnimationFrame(update);
  }

  function handleResize() {
    top();
    windowHeight = window.innerHeight || document.documentElement.clientHeight;
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
