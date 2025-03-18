import { triggerCustomEvent } from '@area17/a17-helpers';

const dynamicFilterDropdown = function(container) {
  let active = false;
  let initialTitle = '';
  const trigger = container.querySelector('.dropdown__trigger');
  const button = trigger ? trigger.querySelector('button') : null;
  const dropdownList = container.querySelector('.dropdown__list');
  
  function _setup() {
    // Store only the text content, not including the SVG
    initialTitle = button.childNodes[0].textContent.trim();
    container.addEventListener('click', _clicks);
  }
  
  function _clicks(event) {
    let active = container.classList.contains('is-open');
    console.log("active state: ", active); // Fixed syntax error here
    
    // Evaluate for opening
    if (!active && container.contains(event.target)) {
      console.log('clicked');
      _open();
    }
    
    // Evaluate for clicking item inside
    if (active && dropdownList.contains(event.target)) {
      let selectedItem = event.target;
      triggerCustomEvent(document, 'filter:reset');
      
      // Only update the text node, not the entire innerHTML
      updateButtonText(selectedItem.innerText);
      
      console.log(initialTitle);
      if (selectedItem.classList.contains('s-active')) {
        updateButtonText(selectedItem.innerText);
      }
    }
    
    // Evaluate for clicking outside
    if (active && !dropdownList.contains(event.target)) {
      console.log('clicked outside');
      _close();
    }
  }
  
  // Helper function to update only the text part of the button
  function updateButtonText(newText) {
    // If the first node is a text node, update it
    if (button.childNodes[0].nodeType === Node.TEXT_NODE) {
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
  
  function _filterUpdated() {
    // Handle filter updated event
  }
  
  function _init() {
    _setup();
    document.addEventListener('filter:updated', _filterUpdated);
  }
  
  this.destroy = function() {
    document.removeEventListener('filter:updated', _filterUpdated);
  };
  
  this.init = function() {
    _init();
  };
}

export default dynamicFilterDropdown;