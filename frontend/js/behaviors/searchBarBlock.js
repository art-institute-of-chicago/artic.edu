import { purgeProperties } from '@area17/a17-helpers';

const searchBarBlock = function(container) {

  function _executeSearch(event) {
    event.preventDefault();
    document.location.href = container.getAttribute('data-url')
    .replace('{query}', container.getElementsByTagName('input')[0].value);
  }

  function _init() {
    container.addEventListener('submit', _executeSearch, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    container.removeEventListener('submit', _executeSearch);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default searchBarBlock;
