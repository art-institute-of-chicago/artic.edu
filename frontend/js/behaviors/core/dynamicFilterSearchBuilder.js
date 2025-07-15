const dynamicFilterSearchBuilder = function(container) {
  let baseUrl = container.getAttribute('data-base-url');
  let searchParams = {};

  function updateSearchTarget(parameter, value) {
    if (value === null || value === undefined || value === '') {
      delete searchParams[parameter];
    } else {
      searchParams[parameter] = value;
    }

    const urlParams = new URLSearchParams();

    Object.entries(searchParams).forEach(([param, val]) => {
      urlParams.set(param, val);
    });

    const queryString = urlParams.toString();
    container.href = queryString ? `${baseUrl}?${queryString}` : baseUrl;
  }

  function handleFilterUpdate(event) {
    updateSearchTarget(event.data.parameter, event.data.value);
  }

  function _init() {
    container.href = baseUrl;
    document.addEventListener('filter:updated', handleFilterUpdate);
  }

  this.init = function() {
    _init();
  };

  this.destroy = function() {
    document.removeEventListener('filter:updated', handleFilterUpdate);
  }
}

export default dynamicFilterSearchBuilder;