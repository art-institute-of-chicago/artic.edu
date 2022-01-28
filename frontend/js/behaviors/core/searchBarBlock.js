const searchBarBlock = function(container) {

  function _executeSearch(event) {
    event.preventDefault();

    let url = container
      .getAttribute('data-url')
      .replace('{query}', container.getElementsByTagName('input')[0].value);

    window.open(url);
  }

  function _init() {
    container.addEventListener('submit', _executeSearch, false);
  }

  this.destroy = function() {
    // Remove specific event handlers
    container.removeEventListener('submit', _executeSearch);

    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default searchBarBlock;
