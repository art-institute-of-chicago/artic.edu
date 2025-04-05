import { triggerCustomEvent } from "@area17/a17-helpers";
import generateComponentId from '../../functions/core/generateComponentId';

const dynamicFilterButton = function(container) {
    const id = generateComponentId();
    const parameter = 'filter';
    const buttonValue = container.getAttribute('data-button-value');

    function _clicks(event) {
        let value = null;
        
        if (container.contains(event.target)) {
          if (!container.classList.contains('s-active')) {
            container.classList.add('s-active');
            value = buttonValue;
          }
          
          triggerCustomEvent(document, 'filter:updated', {
            id: id,
            parameter: parameter,
            value: value,
          });
        } else {
          const targetWithValue = event.target.hasAttribute('data-button-value') ? event.target : event.target.closest('[data-button-value]');
          if (targetWithValue && 
              !targetWithValue.parentNode.hasAttribute('data-dropdown-list') && !value) {
            container.classList.remove('s-active');
          }
        }
      }

    function _filterRegister() {
        triggerCustomEvent(document, 'filter:register', {
            id: id,
            parameter: parameter,
            value: buttonValue,
        })
    }

    function _updateFilter(event) {
        if ((event.data.id === id) && (event.data.parameter === parameter) && (event.data.value === buttonValue)) {
            container.classList.add('s-active');
        } else {
            if (event.data.parameter === parameter && event.data.value !== buttonValue) {
              container.classList.remove('s-active');
            }
        }
    }

    function _init() {
        _filterRegister();
        document.addEventListener('click', _clicks);
        document.addEventListener('filter:castUpdate', _updateFilter);
        document.addEventListener('filter:updated', _updateFilter);
    }

    this.init = function() {
        _init();
    }
}

export default dynamicFilterButton;