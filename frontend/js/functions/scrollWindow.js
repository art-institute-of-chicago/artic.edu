const setScrollDirection = function(win, onProgressCallback) {
  let windowEl = win;
  let onProgressCallbackFct = onProgressCallback;
  let boundUpdateScrollProgress;
  let isTicking = false;
  let progress = 0;

  function _init() {
    window.addEventListener('scroll', _requestTick, false);
    boundUpdateScrollProgress = _updateScrollProgress.bind(this);
    _requestTick();
  }

  function _getScrollY() {
    return window.pageYOffset !== undefined
      ? window.pageYOffset
      : (document.documentElement || document.body.parentNode || document.body).scrollTop;
  }

  function _getViewportHeight() {
    return Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
  }

  function _updateScrollProgress() {
    isTicking = false;
    var el = windowEl;
    var viewportHeight = _getViewportHeight();
    var scroll = _getScrollY();
    var bodyRect = document.body.getBoundingClientRect();
    var rect = el.getBoundingClientRect();
    var middleScroll = scroll + viewportHeight / 2;
    var rangeStart = rect.top - bodyRect.top;
    var rangeEnd = rect.top - bodyRect.top + rect.height;
    progress = (100 * (middleScroll - rangeStart)) / (rangeEnd - rangeStart);
    _onProgress();
  }

  function _requestTick() {
    if (!isTicking) {
      requestAnimationFrame(boundUpdateScrollProgress);
    }
    isTicking = true;
  }

  function _onProgress() {
    if(onProgressCallbackFct) {
      onProgressCallback(progress);
    }
  }

  _init();
};

export default scrollWindow;