const headerHeight = function() {

  function _adjustHeaderOffet() {

    var header = document.getElementsByTagName('header')[0];
    var a17 = document.getElementById('a17');

    a17.style['padding-top'] = null;

    if (header.getElementsByClassName('m-notification--header').length < 1)
    {
      return null;
    }

    if (parseInt(getComputedStyle(a17)['padding-top'], 10) > 0)
    {
      a17.style['padding-top'] = header.offsetHeight + 'px';
    }

  }

  document.addEventListener('notification:confirmed', _adjustHeaderOffet, false);
  document.addEventListener('ajaxPageLoad:complete', _adjustHeaderOffet, false);
  window.addEventListener('resized', _adjustHeaderOffet, false);

  _adjustHeaderOffet();
}

export default headerHeight;
