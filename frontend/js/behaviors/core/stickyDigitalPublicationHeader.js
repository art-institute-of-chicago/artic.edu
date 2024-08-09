const stickyDigitalPublicationHeader = function(container) {
  const HEADER_HEIGHT = 180; // in px
  const HEADER_STICKY = 's-sticky-digital-publication-header';
  const HEADER_UNSTICKY = 's-unsticky-digital-publication-header';

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
    let possibleStates = [HEADER_STICKY, HEADER_UNSTICKY];
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
    if (currentState == HEADER_STICKY) {
      container.scrollTo(0, 0);
    }
  };

  let currentState;
  let containerTop = getOffsetTop(container) + document.body.scrollTop;

  function handleScroll() {
    window.requestAnimationFrame(update);
  }

  function update() {
    let scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
    let containerHeight = container.offsetHeight;

    if (scrollTop < (containerTop + containerHeight - HEADER_HEIGHT)) {
      setState(HEADER_UNSTICKY);
    } else {
      setState(HEADER_STICKY);
    }
  }

  function _init() {
    window.addEventListener('scroll', handleScroll);
    setState(HEADER_STICKY);
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
