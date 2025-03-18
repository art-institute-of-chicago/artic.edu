import { triggerCustomEvent } from "@area17/a17-helpers"
import { dynamicFilterSetup } from ".";

const dynamicFilterSearch = function(container) {
    let searchBar = container.querySelector('input');

    function _handleSubmit(event) {
        event.preventDefault();

        triggerCustomEvent(document, 'filter:reset');
        triggerCustomEvent(document, 'filter:updated', { 
            filterText: searchBar.value 
        });
    }

    function _filterRegister() {
        triggerCustomEvent(document, 'filter:register', {

        })
    }

    function _init() {
        container.addEventListener('submit', _handleSubmit);
        document.addEventListener('filter:init', _filterRegister())
    }

    this.init = function() {
        _init();
    }
}

export default dynamicFilterSearch;