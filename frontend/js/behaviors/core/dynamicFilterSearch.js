import { triggerCustomEvent } from "@area17/a17-helpers"
import generateComponentId from '../../functions/core/generateComponentId';

const dynamicFilterSearch = function (container) {
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

  function _handleChange(event) {
    let clearBtn = container.querySelector('.m-search-bar__clear');

    if (searchBar.value.trim() !== '') {
      if (!clearBtn) {
        let button = container.querySelector('.m-search-bar__submit');
        if (button) {
          button.insertAdjacentHTML('afterend', `<a style="display:block;position:absolute;right:56px;background:transparent;color:#000;" class="m-search-bar__clear" aria-label="Clear search"><svg aria-hidden="true" class="icon--close"><use xlink:href="#icon--close"></use></svg></a>`);
          container.querySelector('.m-search-bar__clear').addEventListener('click', _handleClear);
        }
      }
    }
  }

  function _handleClear(event) {
    if (event) event.preventDefault();
    container.querySelector('.m-search-bar__clear').removeEventListener('click', _handleClear);
    container.querySelector('.m-search-bar__clear').remove();

    triggerCustomEvent(document, 'filter:updated', {
      id: id,
      parameter: 'search',
      value: '',
    });

    searchBar.value = '';
    _handleChange();
  }

  function _handleCastUpdate(event) {
    if (event.data.id === id) {
      searchBar.value = event.data.value || '';
      _handleChange();
    }
  }

  function _handleCleared(event) {
    searchBar.value = '';
    _handleChange();
  }

  function _init() {
    _filterRegister();
    container.addEventListener('submit', _handleSubmit);
    container.addEventListener('input', _handleChange);

    let clearBtn = container.querySelector('.m-search-bar__clear');
    if (clearBtn) {
      clearBtn.addEventListener('click', _handleClear);
    }

    document.addEventListener('filter:castUpdate', _handleCastUpdate);
    document.addEventListener('filter:cleared', _handleCleared);

    _handleChange();
  }

  this.destroy = function () {
    container.removeEventListener('submit', _handleSubmit);
    container.removeEventListener('input', _handleChange);
    document.removeEventListener('filter:castUpdate', _handleCastUpdate);
    document.removeEventListener('filter:cleared', _handleCleared);

    let clearBtn = container.querySelector('.m-search-bar__clear');
    if (clearBtn) {
      clearBtn.removeEventListener('click', _handleClear);
    }
  };

  this.init = function () {
    _init();
  }
}

export default dynamicFilterSearch;