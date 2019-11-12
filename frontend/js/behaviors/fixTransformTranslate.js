import { purgeProperties } from '@area17/a17-helpers';

const fixTransformTranslate = function(container) {

  function _fix(event) {
    let fixHeight = parent.innerHeight % 2 && (container.clientHeight || container.offsetHeight) % 2;
    let fixWidth = parent.innerWidth % 2 && (container.clientWidth || container.offsetWidth) % 2;

    container.style.transform = [
      'translateX(calc(-50%' + (fixWidth ? ' + 0.5px' : '') + '))',
      'translateY(calc(-50%' + (fixHeight ? ' + 0.5px' : '') + '))',
    ].join(' ');
  }

  function _init() {
    container.addEventListener('load', _fix, false);
    window.addEventListener('resized', _fix, false);

    _fix();
  }

  this.destroy = function() {
    // remove specific event handlers
    container.removeEventListener('load', _fix);
    window.removeEventListener('resized', _fix);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default fixTransformTranslate;
