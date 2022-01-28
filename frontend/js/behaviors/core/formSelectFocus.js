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
    // Remove specific event handlers
    container.querySelector('select').removeEventListener('focus', _focus);
    container.querySelector('select').removeEventListener('blur', _blur);

    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default formSelectFocus;
