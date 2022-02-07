import { cookieHandler } from '@area17/a17-helpers';

const limitSearch = function(container) {

  let form = _findAncestor(container, 'm-search-bar');

  let cookieName = 'isSearchLimited';
  let initAsLimited = cookieHandler.read(cookieName) === 'true';

  function _initSwapActions() {
    if (initAsLimited) {
      container.checked = true;
      _swapActions();
    }
  }

  function _handleClicks(event) {
    initAsLimited = !initAsLimited;
    cookieHandler.create(cookieName, initAsLimited, 1);

    _swapActions();
  }

  function _swapActions() {
    let newAction = container.getAttribute('value');
    let oldAction = form.getAttribute('action');

    container.setAttribute('value', oldAction);
    form.setAttribute('action', newAction);
  }

  function _findAncestor (el, cls) {
    while ((el = el.parentElement) && !el.classList.contains(cls));
    return el;
  }

  function _init() {
    container.addEventListener('click', _handleClicks, false);

    _initSwapActions();
  }

  this.destroy = function() {
    // Remove specific event handlers
    container.removeEventListener('click', _handleClicks);

    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default limitSearch;
