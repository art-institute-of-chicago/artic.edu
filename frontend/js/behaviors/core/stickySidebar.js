import { triggerCustomEvent, setFocusOnTarget } from '@area17/a17-helpers';
import { mediaQuery } from '../../functions/core';

const stickySidebar = function(container){

  const getOffsetTop = element => {
    let offsetTop = 0;
    while(element) {
      offsetTop += element.offsetTop;
      element = element.offsetParent;
    }
    return offsetTop;
  }

  const outerHeight = element => {
    var height = element.offsetHeight;
    var style = getComputedStyle(element);

    height += parseInt(style.marginTop) + parseInt(style.marginBottom);
    return height;
  }

  const setState = targetState => {
    let classList = document.documentElement.classList;

    [
      'is-sidebar-top',
      'is-sidebar-grabbed',
      'is-sidebar-fixed',
      'is-sidebar-bottom',
    ].forEach(state => {
      if (state !== targetState && classList.contains(state)) {
        classList.remove(state);
      }
    });

    if (targetState && !classList.contains(targetState)) {
      classList.add(targetState);
    }

    currentState = targetState;
  }

  const resetScroll = () => {
    if (['is-sidebar-fixed','is-sidebar-bottom'].includes(currentState)) {
      container.scrollTo(0, 0);
    }
  }

  let article = document.querySelector('.o-article');
  let logo = document.querySelector('.m-article-actions--publication__logo');

  let scrollTop;

  let windowHeight;
  let containerTop;
  let containerBottom;
  let containerHeight;

  const sidebarOverlayState = 'is-sidebar-overlay';
  let overlayActive = document.documentElement.classList.contains(sidebarOverlayState);

  let savedFocus;
  let savedScroll;

  let currentState;

  // Null if absent, empty string if present
  let isLogoAnimated = container.getAttribute('data-sticky-animated-logo') !== null;
  let grabTop;

  function update() {
    scrollTop = document.documentElement.scrollTop || document.body.scrollTop;

    if (scrollTop < containerTop) {
      if (!isLogoAnimated) {
        top();
      } else {
        if (scrollTop < grabTop) {
          top();
        } else {
          grab();
        }
      }
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
    resetScroll();
    setState('is-sidebar-top');
  }

  function grab() {
    resetScroll();
    setState('is-sidebar-grabbed');
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

    logo.setAttribute('style', 'display: block');
    grabTop = containerTop - outerHeight(logo);
    logo.removeAttribute('style');

    handleScroll();
  }

  // Adapting some things from collectionFilters below:

  function _showSidebar() {
    if (overlayActive) {
      return;
    }

    overlayActive = true;

    // Allows us to catch hashchange for citation button
    history.replaceState(null, null, ' ');

    if (mediaQuery('medium-')) {
      savedScroll = window.scrollY;
      savedFocus = document.activeElement || document.querySelector('body');
      triggerCustomEvent(document, 'body:lock', {
        breakpoints: 'all'
      });
      window.requestAnimationFrame(function(){
        document.documentElement.classList.add(sidebarOverlayState);
        setTimeout(function(){ setFocusOnTarget(container); }, 0)
        triggerCustomEvent(document, 'focus:trap', {
          element: container
        });
      });
    } else {
      document.documentElement.classList.add(sidebarOverlayState);
    }
  }

  function _hideSidebar() {
    if (!overlayActive) {
      return;
    }
    triggerCustomEvent(document, 'body:unlock');
    triggerCustomEvent(document, 'focus:untrap');
    setTimeout(function() {
      if (savedFocus) {
        setFocusOnTarget(savedFocus);
      }
      setTimeout(function() {
        if (savedScroll) {
          window.scroll(0, savedScroll);
        }
      }, 0);
    }, 0)
    document.documentElement.classList.remove(sidebarOverlayState);
    overlayActive = false;
  }

  function _toggleSidebar() {
    if (!overlayActive) {
      triggerCustomEvent(document, 'stickySidebar:open');
    } else {
      triggerCustomEvent(document, 'stickySidebar:close');
    }
  }

  function _cleanSidebar() {
    _hideSidebar();
    setState(null);
  }

  function _mediaQueryUpdated() {
    if (overlayActive) {
      triggerCustomEvent(document, 'stickySidebar:close');
      triggerCustomEvent(document, 'stickySidebar:open');
    }
  }

  function _init() {
    window.addEventListener('scroll', handleScroll);
    window.addEventListener('resized', handleResize);

    document.addEventListener('stickySidebar:open', _showSidebar, false);
    document.addEventListener('stickySidebar:close', _hideSidebar, false);
    document.addEventListener('stickySidebar:toggle', _toggleSidebar, false);
    document.addEventListener('stickySidebar:clean', _cleanSidebar, false);
    document.addEventListener('mediaQueryUpdated',_mediaQueryUpdated, false);

    window.addEventListener('hashchange', _hideSidebar, false);

    handleResize();
    handleScroll();
  }

  this.destroy = function() {
    window.removeEventListener('resized', handleResize);
    window.removeEventListener('scroll', handleScroll);

    document.removeEventListener('stickySidebar:open', _showSidebar);
    document.removeEventListener('stickySidebar:close', _hideSidebar);
    document.removeEventListener('stickySidebar:toggle', _toggleSidebar);
    document.removeEventListener('stickySidebar:clean', _cleanSidebar);
    document.removeEventListener('mediaQueryUpdated',_mediaQueryUpdated);

    window.removeEventListener('hashchange', _hideSidebar);

    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default stickySidebar;
