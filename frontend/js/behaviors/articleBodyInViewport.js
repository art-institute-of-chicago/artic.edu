import { purgeProperties, getOffset, forEach } from 'a17-helpers';

const articleBodyInViewport = function(container) {

  const dE = document.documentElement;

  let position = 'default';
  let lockTop = 0;
  let lockBottom = 0;
  let topBudge = 80;
  let isSetUp = false;
  let lastScrollTop = 0;
  let tallEnough = false;

  function _posDefault() {
    dE.classList.remove('s-article-sticky-bottom');
    dE.classList.remove('s-article-sticky-fixed');
    position = 'default';
  }

  function _posFixed() {
    dE.classList.remove('s-article-sticky-bottom');
    dE.classList.add('s-article-sticky-fixed');
    position = 'fixed';
  }

  function _posBottom() {
    dE.classList.add('s-article-sticky-bottom');
    dE.classList.remove('s-article-sticky-fixed');
    position = 'bottom';
  }

  function _decidePos() {
    if (isSetUp) {
      var sT = document.documentElement.scrollTop || document.body.scrollTop;
      if (tallEnough) {
        if (sT >= lockBottom && position !== 'bottom') {
          _posBottom();
        } else if (sT >= lockTop && sT < lockBottom && position !== 'fixed') {
          _posFixed();
        } else if (sT < lockTop && position !== 'default') {
          _posDefault();
        }
      }
      lastScrollTop = sT;
      window.requestAnimationFrame(_decidePos);
    }
  }

  function _resetPos() {
    _posDefault();
    _decidePos();
  }

  function _calcLockPositions() {
    container.style.minHeight = 0;
    var fixedBoundingClientRect = getOffset(container);
    if (fixedBoundingClientRect.height > (window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight)) {
      lockTop = Math.round(fixedBoundingClientRect.top) - topBudge;
      lockBottom = lockTop + Math.round(fixedBoundingClientRect.height);
      tallEnough = true;
    } else {
      tallEnough = false;
    }
    _resetPos();
  }

  function _destroy() {
    if (isSetUp) {
      window.removeEventListener('load',_calcLockPositions);
      window.removeEventListener('resized',_calcLockPositions);
      document.removeEventListener('fonts:loaded',_calcLockPositions);
      document.removeEventListener('page:updated',_calcLockPositions);
      /*
      forEach(document.querySelectorAll('img'), function(index, img) {
        img.removeEventListener('load', _calcLockPositions);
      });
      */
      isSetUp = false;
    }
  }

  function _setup() {
    if (!isSetUp) {
      window.addEventListener('load',_calcLockPositions, false);
      window.addEventListener('resized',_calcLockPositions, false);
      document.addEventListener('fonts:loaded',_calcLockPositions, false);
      document.addEventListener('page:updated',_calcLockPositions, false);
      /*
      forEach(document.querySelectorAll('img'), function (index, img) {
        img.addEventListener('load', _calcLockPositions, false);
        try {
          if (img.complete) {
            img.load();
          }
        } catch(err) {}
      });
      */
      _calcLockPositions();
      _decidePos();
      isSetUp = true;
    }
  }

  function _decide() {
    _destroy();
    _setup();
  }

  function _init() {
    _decide();
    document.addEventListener('resized', _decide, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    _destroy();

    // remove properties of this behavior
    purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default articleBodyInViewport;
