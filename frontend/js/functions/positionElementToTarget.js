
const positionElementToTarget = function(options) {

  if (!options && !options.element && !options.target) {
    return;
  }

  let element = options.element;
  let target = options.target;
  let padding = (options.padding === undefined) ? { left: 0, top: 0 } : options.padding;
  let position = (options.position === undefined) ? 'bottom left' : options.position;
  let breakpoints = options.breakpoints || false;

  padding.left = (options.padding === undefined || options.padding.left === undefined) ? 0 : padding.left;
  padding.top = (options.padding === undefined || options.padding.top === undefined) ? 0 : padding.top;

  element.style.opacity = 0;

  let a17BoundingClientRect = document.getElementById('a17').getBoundingClientRect();
  let targetBoundingClientRect = target.getBoundingClientRect();
  let elementBoundingClientRect = element.getBoundingClientRect();
  let sT = document.documentElement.scrollTop || document.body.scrollTop;
  let left = 0;
  let top = 0;

  function _alignToBottom() {
    top = targetBoundingClientRect.top + targetBoundingClientRect.height + sT + padding.top;
  }

  function _alignToTop() {
    top = targetBoundingClientRect.top + sT - padding.top - elementBoundingClientRect.height;
  }

  function _alignToLeft() {
    left = targetBoundingClientRect.left + padding.left;
  }

  function _alignToHorizCenter() {
    _alignToLeft();
    left += ((targetBoundingClientRect.width / 2) - (elementBoundingClientRect.width / 2) - padding.left);
  }

  function _alignToRight() {
    left = targetBoundingClientRect.left + targetBoundingClientRect.width - elementBoundingClientRect.width - padding.left;
  }

  if (padding.left !== 'auto') {
    if (position.indexOf('left') > -1) {
      _alignToLeft();
    }

    if (position.indexOf('center') > -1) {
      _alignToHorizCenter();
    }

    if (position.indexOf('right') > -1) {
      _alignToRight();
    }
  } else {
    _alignToLeft();
  }

  if (position.indexOf('top') > -1) {
    _alignToTop();
  } else {
    _alignToBottom();
  }

  // Check for out of bounds
  if (sT > top) {
    _alignToBottom();
  }


  if (padding.left !== 'auto') {
    if (left + elementBoundingClientRect.width > window.innerWidth) {
      _alignToRight();
    } else if (left < padding.left) {
      left = padding.left;
    }
  }

  element.classList.add('js-positioned');
  if (!breakpoints || (breakpoints && breakpoints[A17.currentMediaQuery])) {
    if (padding.left !== 'auto') {
      element.style.left = Math.round(left) + 'px';
    }
    element.style.top = Math.round(top) + 'px';
  } else {
    element.style.left = '125px';
    element.style.top = '';
    element.style.width = '300px';
  }
  element.style.opacity = 1;
};

export default positionElementToTarget;
