import { purgeProperties, triggerCustomEvent } from '@area17/a17-helpers';

const modal = function(container) {
  var close = container.querySelector('[data-modal-close]');
  var klass = 's-modal-active';

  function _close(e) {
    document.documentElement.classList.remove(klass);

    e.preventDefault();
  }

  function _init() {
    document.addEventListener('modal:close', _close, false);
    close.addEventListener('click', _close, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    document.removeEventListener('modal:close', _close);
    close.removeEventListener('click', _close);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default modal;
