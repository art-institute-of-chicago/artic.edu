const ajaxPageLoadMaskToggle = function() {

  let active = false;

  function _show() {
    if (!active) {
      active = true;
      document.documentElement.classList.add('s-ajaxPageLoadMask-active');
    }
  }

  function _hide() {
    if (active) {
      active = false;
      document.documentElement.classList.remove('s-ajaxPageLoadMask-active');
    }
  }

  document.addEventListener('ajaxPageLoadMask:show', _show, false);
  document.addEventListener('ajaxPageLoadMask:hide', _hide, false);
};

export default ajaxPageLoadMaskToggle;
