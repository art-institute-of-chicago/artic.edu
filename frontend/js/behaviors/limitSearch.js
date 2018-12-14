import { purgeProperties } from '@area17/a17-helpers';

const limitSearch = function(container) {

  let form = _findAncestor(container, 'm-search-bar');

  function _handleClicks(event) {
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
  }

  this.destroy = function() {
    // remove specific event handlers
    container.removeEventListener('click', _handleClicks);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default limitSearch;
