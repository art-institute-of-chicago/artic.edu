import { purgeProperties } from 'a17-helpers';

const imageInfo = function(container) {

  const info = container.nextElementSibling;

  function _triggerClicks() {
    container.blur();
    container.setAttribute('aria-expanded','true');
    container.setAttribute('aria-selected','true');
    info.setAttribute('aria-hidden','false');
  }

  function _infoClicks() {
    info.blur();
    container.setAttribute('aria-expanded','false');
    container.setAttribute('aria-selected','false');
    info.setAttribute('aria-hidden','true');
  }

  function _init() {
    container.addEventListener('click', _triggerClicks, false);
    info.addEventListener('click', _infoClicks, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    container.removeEventListener('click', _triggerClicks);
    info.removeEventListener('click', _infoClicks);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default imageInfo;
