import { getOffset } from '@area17/a17-helpers';
import { mediaQuery } from '../../functions/core';

const stickyFilters = function(container){

  let position = 'default';
  let lockTop = 0;
  let lockBottom = 0;
  let topBudge = 0;
  let dE = document.documentElement;
  let breakpoints = container.getAttribute('data-stickyElement-breakpoints') || 'all';
  let halt = true;
  let rAF;

  function _posDefault() {
    dE.classList.remove('s-sticky-filters--fixed');
    dE.classList.remove('s-sticky-filters--bottom');
    position = 'default';
  }

  function _posFixed() {
    dE.classList.add('s-sticky-filters--fixed');
    dE.classList.remove('s-sticky-filters--bottom');
    position = 'fixed';
  }

  function _posBottom() {
    dE.classList.remove('s-sticky-filters--fixed');
    dE.classList.add('s-sticky-filters--bottom');
    position = 'bottom';
  }

  function _decidePos() {
    if (mediaQuery(breakpoints) && !halt) {
      let sT = document.documentElement.scrollTop || document.body.scrollTop;
      if (sT >= lockBottom && position !== 'bottom') {
        _posBottom();
      } else if (sT >= lockTop && sT < lockBottom && position !== 'fixed') {
        _posFixed();
      } else if (sT < lockTop && position !== 'default') {
        _posDefault();
      }
    }
    cancelAnimationFrame(rAF);
    rAF = window.requestAnimationFrame(_decidePos);
  }

  function _calcLockPositions() {
    _posDefault();
    halt = true;
    window.requestAnimationFrame(function(){
      if (mediaQuery(breakpoints)) {
        let fixedBoundingClientRect = getOffset(container);
        lockTop = Math.round(fixedBoundingClientRect.top) - topBudge;
        lockBottom = lockTop + Math.round(fixedBoundingClientRect.height);
        halt = false;
      }
    });
  }

  function _pageUpdated() {
    window.requestAnimationFrame(function(){
      _calcLockPositions();
      cancelAnimationFrame(rAF);
      rAF = window.requestAnimationFrame(_decidePos);
    });
  }

  function _destroy() {
    _posDefault();
    cancelAnimationFrame(rAF);
    window.removeEventListener('load', _calcLockPositions);
    window.removeEventListener('resized', _calcLockPositions);
    window.removeEventListener('mediaQueryUpdated', _calcLockPositions);
    document.removeEventListener('fonts:loaded', _calcLockPositions);
    document.removeEventListener('page:updated', _pageUpdated);
  }

  function _setup() {
    window.addEventListener('load', _calcLockPositions, false);
    window.addEventListener('resized', _calcLockPositions, false);
    window.addEventListener('mediaQueryUpdated', _calcLockPositions, false);
    document.addEventListener('fonts:loaded', _calcLockPositions, false);
    document.addEventListener('page:updated', _pageUpdated, false);
    _calcLockPositions();
    cancelAnimationFrame(rAF);
    rAF = window.requestAnimationFrame(_decidePos);
  }

  function _init() {
    _setup();
  }

  this.destroy = function() {
    _destroy();

    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default stickyFilters;
