// dynamicFilterDropdown.js
import { triggerCustomEvent } from '@area17/a17-helpers';
import generateComponentId from '../../functions/core/generateComponentId';
import { drop, forEach, indexOf } from 'lodash';

const dynamicFilterDropdown = function(container) {
  
  const id = generateComponentId();

  container.setAttribute("data-filter-id", id);

  let active = false;
  let initialTitle = '';
  let initialized = false;
  
  // Fallback to data-behavior if data-filter-behavior is not present
  const filterType = container.getAttribute('data-filter-behavior');
  const trigger = container.querySelector('.dropdown__trigger');
  const button = trigger ? trigger.querySelector('button') : null;
  const dropdownList = container.querySelector('.dropdown__list');
  const dropdownItems = container.querySelectorAll('[data-button-value]');
  
  function _setup() {
    if (button && button.childNodes.length > 0) {
      initialTitle = button.childNodes[0].textContent.trim();
    }
    container.addEventListener('click', _clicks);
  }
  
  function _clicks(event) {
    let isActive = container.classList.contains('is-open');
    // Evaluate for opening
    if (!isActive && container.contains(event.target)) {
      _open();
    }
    
    // Evaluate for clicking item inside
    if (isActive && dropdownList && dropdownList.contains(event.target)) {
      let selectedItem = event.target;
      let selectedValue = selectedItem.closest('[data-button-value]').getAttribute('data-button-value');
      let value = null;
      
      dropdownItems.forEach(item => {
        if ((item.getAttribute('data-button-value') === selectedValue) && selectedItem.closest('[data-button-value]').classList.contains('s-active')) {
          item.classList.remove('s-active');
        } else if (item.getAttribute('data-button-value') === selectedValue) {
          item.classList.add('s-active');
          value = selectedValue;
        } else {
          item.classList.remove('s-active');
        }
      });

      console.log(value);
    
      if (value) {
        trigger.classList.add('s-active');
        updateButtonText(selectedItem.innerText);
        triggerCustomEvent(document, 'filter:updated', {
          id: id,
          parameter: filterType,
          value: value
        });
      } else {
        trigger.classList.remove('s-active');
        updateButtonText(initialTitle);
        triggerCustomEvent(document, 'filter:updated', {
          id: id,
          parameter: filterType,
          value: null
        });
      }

      _close();
    }
    
    // Evaluate for clicking outside
    if (isActive && !dropdownList.contains(event.target)) {
      _close();
    }
  }

  function resetFilter(event) {
    if (event.data.parameter === filterType && event.data.id !== id){
      updateButtonText(initialTitle);
      trigger.classList.remove('s-active');
      dropdownItems.forEach(item => {
        item.classList.remove('s-active');
      });
    }
  }
  
  // Helper function to update only the text part of the button
  function updateButtonText(newText) {
    if (!button) {
      return;
    }
    
    // If the first node is a text node, update it
    if (button.childNodes.length > 0 && button.childNodes[0].nodeType === Node.TEXT_NODE) {
      button.childNodes[0].textContent = newText;
    } else {
      // If for some reason the first node isn't text, replace it
      const textNode = document.createTextNode(newText);
      button.insertBefore(textNode, button.firstChild);
    }
  }
  
  function _open() {
    container.classList.add('s-active');
    container.classList.add('is-open');
    active = true;
  }
  
  function _close() {
    container.classList.remove('s-active');
    container.classList.remove('is-open');
    active = false;
  }
  
  function _filterRegister() {
    triggerCustomEvent(document, 'filter:register', {
        id: id,
        parameter: filterType,
        values: Array.from(dropdownItems).map(item => 
          item.getAttribute('data-button-value')
        )
    })
  }
  
  function _init() {
    _setup();
    _filterRegister();

    document.addEventListener('filter:init', _filterRegister);
    document.addEventListener('filter:updated', resetFilter);
    document.addEventListener('filter:castUpdate', function(event) {
      if (event.data.id === id) {

        const matchingItem = Array.from(dropdownItems).find(item => 
          item.getAttribute('data-button-value') === event.data.value
        );
        
        if (matchingItem) {
          trigger.classList.add('s-active');
          matchingItem.classList.add('s-active');
          updateButtonText(matchingItem.innerText);
        }
      }
    });
    
    initialized = true;
  }
  
  this.destroy = function() {
    container.removeEventListener('click', _clicks);
    document.removeEventListener('filter:init', _filterRegister);
    document.removeEventListener('filter:updated', resetFilter(event));
    document.removeEventListener('filter:castUpdate')
  };
  
  this.init = function() {
    if (!initialized) {
      _init();
    }
  };
};

export default dynamicFilterDropdown;