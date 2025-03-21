import { triggerCustomEvent } from "@area17/a17-helpers"
import generateUUID from '../../functions/core/generateUUID';

const dynamicFilterSearch = function(container) {
    let id = generateUUID();
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
            console.log('search hears castupdate');
            if (event.data.id === id) {
                searchBar.value = event.data.value;

                triggerCustomEvent(document, 'filter:updated', {
                    id: id,
                    parameter: 'search',
                    value: searchBar.value,
                });
            }
        });
    }

    this.init = function() {
        _init();
    }
}

export default dynamicFilterSearch;