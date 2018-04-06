import { purgeProperties } from '@area17/a17-helpers';

const blurMyBackground = function(container) {

  let active = false;
  let $img;
  let $dupe;
  let $clipTarget;

  function _tests() {
    let el;
    //
    el = document.createElement('div');
    el.style.cssText = '-webkit-filter: blur(2px); filter: blur(2px);';
    let filterTest1 = (el.style.length != 0);
    // checking for false positives of IE
    let filterTest2 = (document.documentMode === undefined || document.documentMode > 9);
    let filterTest = (filterTest1 && filterTest2);
    el = null;
    //
    el = document.createElement('div');
    el.style.cssText = '-webkit-clip-path: inset(1px 2px 3px 4px); clip-path: inset(1px 2px 3px 4px);';
    let clippingTest = (el.style.length != 0);
    el = null;
    //
    el = document.createElement('div');
    el.style.cssText = '-webkit-backdrop-filter: blur(2px); backdrop-filter: blur(2px);';
    let backdropFilterTest = (el.style.length != 0);

    // we don't the function to run if backdrop filter is support
    if(backdropFilterTest || !filterTest || clippingTest) {
      active = false;
    }
    // if backdrop filter isn't supported, lets home filter and clip path are
    if(!active && !backdropFilterTest && filterTest && clippingTest) {
      active = true;
    }
  }

  function _dupeImage() {
    let imgHTML = $img.outerHTML.replace('data-blur-img','data-blur-img-dupe');
    $img.insertAdjacentHTML('afterend', imgHTML);
    $dupe = container.querySelector('[data-blur-img-dupe]');
  }

  function _clipDupe() {
    let clipPath = 'clip-path: inset(top right bottom left);';
    let containerRect = container.getBoundingClientRect();
    let clipTargetRect = $clipTarget.getBoundingClientRect();
    if (clipTargetRect.width === 0 && clipTargetRect.height === 0) {
      $dupe.setAttribute('style','clip-path: none; -webkit-clip-path: none; display: none;');
    } else {
      clipPath = clipPath.replace(/left/ig, Math.round(Math.abs(clipTargetRect.left - containerRect.left)) + 'px');
      clipPath = clipPath.replace(/top/ig, Math.round(Math.abs(clipTargetRect.top - containerRect.top)) + 'px');
      clipPath = clipPath.replace(/right/ig, Math.round(Math.abs(clipTargetRect.right - containerRect.right)) + 'px');
      clipPath = clipPath.replace(/bottom/ig, Math.round(Math.abs(clipTargetRect.bottom - containerRect.bottom)) + 'px');
      $dupe.setAttribute('style',clipPath + ' -webkit-' + clipPath);
    }
  }

  function _init() {
    _tests();
    if (!active) {
      return;
    }
    //
    $img = container.querySelector('[data-blur-img]');
    $clipTarget = container.querySelector('[data-blur-clip-to]');
    if ($clipTarget && $img) {
      _dupeImage();
      _clipDupe();
      window.addEventListener('resized', _clipDupe, false);
    }
  }

  this.destroy = function() {
    // remove specific event handlers
    window.removeEventListener('resized', _clipDupe);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default blurMyBackground;
