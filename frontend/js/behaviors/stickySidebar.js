import { purgeProperties, getOffset, triggerCustomEvent, setFocusOnTarget } from '@area17/a17-helpers';
import { mediaQuery, focusTrap } from '../functions';

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

    if (targetState && !classList.contains(targetState)) {
      classList.add(targetState);
    }
  }

  let article = document.querySelector('.o-article');

  let scrollTop;

  let windowHeight;
  let containerTop;
  let containerBottom;
  let containerHeight;

  const sidebarOverlayState = 'is-sidebar-overlay';
  let overlayActive = document.documentElement.classList.contains(sidebarOverlayState);

  let savedFocus;
  let savedScroll;

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

  // Adapting some things from collectionFilters below:

  function _showSidebar() {
    if (overlayActive) {
      return;
    }

    overlayActive = true;

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

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default stickySidebar;
