import { purgeProperties } from 'a17-helpers';

const formSelectFocus = function(container) {

  function _focus() {
    container.classList.add('s-focus');
  }

  function _blur() {
    container.classList.remove('s-focus');
  }

  function _init() {
    container.querySelector('select').addEventListener('focus', _focus, false);
    container.querySelector('select').addEventListener('blur', _blur, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    container.querySelector('select').removeEventListener('focus', _focus);
    container.querySelector('select').removeEventListener('blur', _blur);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default formSelectFocus;
