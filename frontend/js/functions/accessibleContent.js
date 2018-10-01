const accessibleContent = function() {

  function _refresh() {

    // "Skip to Content" should always be the first link on the page
    var a = document.querySelector('a');

    // Check if there is an h1 present
    var h1 = document.querySelector('h1');

    if (h1) {

      // Remove id from existing header, if any
      var old = document.querySelector('#content-h1');
      if (old) {
        old.forEach( function(e) {
          h1.removeAttr('id');
        });
      }

      h1.setAttribute('id', 'content-h1');
      if (a) a.setAttribute('href', '#content-h1');
    } else {
      if (a) a.setAttribute('href', '#content');
    }
  }

  _refresh();

  document.addEventListener('DOMContentLoaded', _refresh, false);
  document.addEventListener('ajaxPageLoad:complete', _refresh, false);
};

export default accessibleContent;
