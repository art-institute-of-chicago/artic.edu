const stickyDigitalPublicationHeader = function(container) {
  const MIN_CONTAINER_HEIGHT = 180; // in px
  const HEADER_IS_STICKY = 's-sticky-digital-publication-header';
  const HEADER_IS_SHRINKING = 's-shrinking-digital-publication-header';

  const getOffsetTop = element => {
    let offsetTop = 0;
    while(element) {
      offsetTop += element.offsetTop;
      element = element.offsetParent;
    }
    return offsetTop;
  };

  const setState = targetState => {
    let classList = document.documentElement.classList;
    let possibleStates = [HEADER_IS_STICKY,  HEADER_IS_SHRINKING];
    possibleStates.forEach(state => {
      if (state !== targetState && classList.contains(state)) {
        classList.remove(state);
      }
    });

    if (targetState && !classList.contains(targetState)) {
      classList.add(targetState);
    }

    currentState = targetState;
  };

  const resetScroll = () => {
    if (currentState == HEADER_IS_STICKY) {
      container.scrollTo(0, 0);
    }
  };

  let currentState;
  let containerOffsetHeight;
  let scrollTop;
  let navContainerHeight;

  function handleScroll() {
    window.requestAnimationFrame(update);
  }

  function handleResize() {
    containerOffsetHeight = getOffsetTop(container) + container.offsetHeight;
    navContainerHeight = document.querySelector('.g-header').clientHeight;
    handleScroll();
  }

  function update() {
    scrollTop = document.documentElement.scrollTop || document.body.scrollTop;

    if (scrollTop < navContainerHeight) {
      // If user has not scrolled past nav container to the digital publication
      // header, unset state
      setState(null);
    } else if (scrollTop < (containerOffsetHeight - MIN_CONTAINER_HEIGHT)) {
      // If user has not scrolled to the container's minimum height, header is
      // "shrinking down to the minimum size"
      setState(HEADER_IS_SHRINKING);
    } else {
      // As user continues to scroll down the page, keep the header stuck to the
      // top of the page
      setState(HEADER_IS_STICKY);
    }
  }

  function _init() {
    window.addEventListener('resized', handleResize);
    window.addEventListener('scroll', handleScroll);
    handleResize();
    resetScroll();
    handleScroll();
  }

  this.destroy = function() {
    window.removeEventListener('scroll', handleScroll);

    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  }

  this.init = function() {
    _init();
  }
}

export default stickyDigitalPublicationHeader;
