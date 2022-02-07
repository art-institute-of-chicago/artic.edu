const imageInfo = function(container) {

  const info = container.nextElementSibling;
  let active = false;

  function _open() {
    container.setAttribute('aria-expanded','true');
    container.setAttribute('aria-selected','true');
    info.setAttribute('aria-hidden','false');
    active = true;
  }

  function _close() {
    container.setAttribute('aria-expanded','false');
    container.setAttribute('aria-selected','false');
    info.setAttribute('aria-hidden','true');
    active = false;
  }

  function _toggle() {
    if (active) {
      _close();
    } else {
      _open();
    }
  }

  function _triggerClicks() {
    container.blur();
    _toggle();
  }

  function _infoClicks() {
    info.blur();
    _toggle();
  }

  function _init() {
    container.addEventListener('click', _triggerClicks, false);
    info.addEventListener('click', _infoClicks, false);
  }

  this.destroy = function() {
    // Remove specific event handlers
    container.removeEventListener('click', _triggerClicks);
    info.removeEventListener('click', _infoClicks);

    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default imageInfo;
