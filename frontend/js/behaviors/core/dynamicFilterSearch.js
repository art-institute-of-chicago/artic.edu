import { triggerCustomEvent } from "@area17/a17-helpers"
import generateComponentId from '../../functions/core/generateComponentId';

const dynamicFilterSearch = function(container) {
  let id = generateComponentId();
  let searchBar = container.querySelector('input');
  container.setAttribute("data-filter-id", id);

  function _handleSubmit(event) {
    event.preventDefault();
    triggerCustomEvent(document, 'filter:updated', {
      id: id,
      parameter: 'search',
      value: searchBar.value,
    });
  }

  function _filterRegister() {
    triggerCustomEvent(document, 'filter:register', {
      id: id,
      parameter: 'search',
      value: ''
    })
  }

  function _init() {
    _filterRegister();
    container.addEventListener('submit', _handleSubmit);

    document.addEventListener('filter:castUpdate', function(event) {
      if (event.data.id === id) {
        searchBar.value = event.data.value || '';
      }
    });

    document.addEventListener('filter:cleared', function(event) {
      // Reset search input to empty when clearing happens
      // Do this silently without triggering updates
      searchBar.value = '';
    });
  }

  this.destroy = function() {
    container.removeEventListener('submit', _handleSubmit);
    document.removeEventListener('filter:castUpdate', null);
    document.removeEventListener('filter:cleared', null);
  };

  this.init = function() {
    _init();
  }
}

export default dynamicFilterSearch;