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

  const filterType = container.getAttribute('data-filter-behavior');
  const filterLabel = container.getAttribute('data-filter-label');
  const filterPersist = container.getAttribute('data-filter-persist') ?? null;
  const isPersistent = filterPersist !== null; // Check if this component should persist

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

      let wasToggedOff = false;

      dropdownItems.forEach(item => {
        if ((item.getAttribute('data-button-value') === selectedValue) && selectedItem.closest('[data-button-value]').classList.contains('s-active')) {
          // Toggle off behavior - remove active state
          item.classList.remove('s-active');
          wasToggedOff = true;
        } else if (item.getAttribute('data-button-value') === selectedValue) {
          // Activate this item
          item.classList.add('s-active');
          value = selectedValue;
        } else {
          // Always remove other active states for single selection behavior
          item.classList.remove('s-active');
        }
      });

      if (value) {
        trigger.classList.add('s-active');

        updateButtonText(selectedItem.innerText);

        // Send filter update event with persistence information
        triggerCustomEvent(document, 'filter:updated', {
          id: id,
          parameter: filterType,
          value: value,
          label: filterLabel,
          useLabel: !!filterLabel,
          persist: isPersistent
        });
      } else {
        // Handle clearing the filter - this happens when toggling off
        trigger.classList.remove('s-active');
        updateButtonText(initialTitle);

        // Send filter update event with null value and force clear flag if explicitly toggled off
        triggerCustomEvent(document, 'filter:updated', {
          id: id,
          parameter: filterType,
          value: null,
          label: filterLabel,
          useLabel: !!filterLabel,
          persist: isPersistent,
          forceClear: wasToggedOff // Indicate this was an explicit toggle off
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
    // For persistent filters, don't reset unless explicitly told to
    if (event.data.parameter === filterType && event.data.id !== id) {
      if (!isPersistent) {
        updateButtonText(initialTitle);
        trigger.classList.remove('s-active');
        dropdownItems.forEach(item => {
          item.classList.remove('s-active');
        });
      }
      // Persistent filters maintain their state when other filters change
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
    // Register with persistence information
    triggerCustomEvent(document, 'filter:register', {
        id: id,
        parameter: filterType,
        values: Array.from(dropdownItems).map(item =>
          item.getAttribute('data-button-value')
        ),
        label: filterLabel,
        persist: isPersistent // Include persistence flag
    });
  }

  // Add method to manually clear persistent filter
  function clearPersistentFilter() {
    if (isPersistent) {
      dropdownItems.forEach(item => {
        item.classList.remove('s-active');
      });

      trigger.classList.remove('s-active');
      updateButtonText(initialTitle);

      // Send clear event
      triggerCustomEvent(document, 'filter:updated', {
        id: id,
        parameter: filterType,
        value: null,
        label: filterLabel,
        useLabel: !!filterLabel,
        persist: isPersistent,
        forceClear: true // Flag to indicate this is a forced clear
      });
    }
  }

  function _init() {
    _setup();
    _filterRegister();

    document.addEventListener('filter:init', _filterRegister);
    document.addEventListener('filter:updated', resetFilter);

    // Add event listener for clearing persistent filters
    document.addEventListener('filter:clearPersistent', function(event) {
      if (event.data && event.data.id === id) {
        clearPersistentFilter();
      }
    });

    document.addEventListener('filter:castUpdate', function(event) {
      // Only process cast updates that are meant for this specific filter instance
      if (event.data.id !== id) {
        return; // Exit early if this update isn't for this filter
      }

      // Handle cast updates, which may come from either parameter or label
      const isLabelCast = event.data.isLabelCast;

      const matchingItem = Array.from(dropdownItems).find(item =>
        item.getAttribute('data-button-value') === event.data.value
      );

      if (matchingItem) {
        trigger.classList.add('s-active');

        // All dropdowns use single selection behavior within themselves
        dropdownItems.forEach(item => {
          if (item === matchingItem) {
            item.classList.add('s-active');
          } else {
            item.classList.remove('s-active');
          }
        });
        updateButtonText(matchingItem.innerText);
      } else if (event.data.value === null || event.data.value === '') {
        // Handle clearing the filter - only clear if not persistent or forced
        if (!isPersistent || event.data.forceClear) {
          dropdownItems.forEach(item => {
            item.classList.remove('s-active');
          });
          trigger.classList.remove('s-active');
          updateButtonText(initialTitle);
        }
      }
    });

    initialized = true;
  }

  this.destroy = function() {
    container.removeEventListener('click', _clicks);
    document.removeEventListener('filter:init', _filterRegister);
    document.removeEventListener('filter:updated', resetFilter);
    document.removeEventListener('filter:castUpdate', null);
    document.removeEventListener('filter:clearPersistent', null);
  };

  this.init = function() {
    if (!initialized) {
      _init();
    }
  };

  // Expose method to manually clear persistent filters
  this.clearPersistent = function() {
    clearPersistentFilter();
  };

  // Expose method to check if filter is persistent
  this.isPersistent = function() {
    return isPersistent;
  };

  // Expose method to get active values (should only be one for single selection)
  this.getActiveValues = function() {
    const activeItems = Array.from(dropdownItems).filter(item => item.classList.contains('s-active'));
    return activeItems.map(item => item.getAttribute('data-button-value'));
  };
};

export default dynamicFilterDropdown;