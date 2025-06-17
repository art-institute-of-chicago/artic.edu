import { triggerCustomEvent } from '@area17/a17-helpers';
import generateComponentId from '../../functions/core/generateComponentId';

const dynamicFilterClear = function(container) {
  const id = generateComponentId();
  container.setAttribute("data-filter-id", id);

  let initialized = false;
  const clearButton = container.querySelector('button, [role="button"], .js-clear-trigger') || container;

  function _setup() {
    clearButton.addEventListener('click', _handleClear);
    clearButton.addEventListener('keydown', _handleKeydown);

    // Ensure the button is accessible
    if (clearButton.tagName !== 'BUTTON' && !clearButton.hasAttribute('role')) {
      clearButton.setAttribute('role', 'button');
      clearButton.setAttribute('tabindex', '0');
    }
  }

  function _handleKeydown(event) {
    // Handle Enter and Space key for accessibility
    if (event.key === 'Enter' || event.key === ' ') {
      event.preventDefault();
      _handleClear(event);
    }
  }

  function _handleClear(event) {
    event.preventDefault();

    // Trigger the clear action - always clear everything
    triggerCustomEvent(document, 'filter:clear', {
      id: id,
      source: 'clear-button'
    });
  }

  function _updateVisibility() {
    // Show/hide the clear button based on active filters
    triggerCustomEvent(document, 'filter:requestActiveFilters', {
      id: id,
      callback: (activeFilters) => {
        const hasActiveFilters = activeFilters && activeFilters.length > 0 &&
          !activeFilters.every(f => f.parameter === 'page' || (f.parameter === 'filter' && f.value === 'all'));

        if (hasActiveFilters) {
          container.style.display = '';
          container.classList.add('is-visible');
        } else {
          container.style.display = 'none';
          container.classList.remove('is-visible');
        }
      }
    });
  }

  function _filterRegister() {
    // Register this component with the filter system
    triggerCustomEvent(document, 'filter:register', {
      id: id,
      parameter: 'clear',
      values: ['all'], // Always clear all
      persist: false // Clear buttons are never persistent
    });
  }

  function _init() {
    _setup();
    _filterRegister();

    // Listen for filter events to update visibility
    document.addEventListener('filter:init', _filterRegister);
    document.addEventListener('filter:updated', _updateVisibility);
    document.addEventListener('filter:castUpdate', _updateVisibility);

    // Listen for clear completion
    document.addEventListener('filter:cleared', function(event) {
      _updateVisibility(); // Update visibility after clear
    });

    // Initial visibility check
    setTimeout(_updateVisibility, 100);

    initialized = true;
  }

  this.destroy = function() {
    clearButton.removeEventListener('click', _handleClear);
    clearButton.removeEventListener('keydown', _handleKeydown);
    document.removeEventListener('filter:init', _filterRegister);
    document.removeEventListener('filter:updated', _updateVisibility);
    document.removeEventListener('filter:castUpdate', _updateVisibility);
    document.removeEventListener('filter:cleared', null);
  };

  this.init = function() {
    if (!initialized) {
      _init();
    }
  };

  // Expose method to manually trigger clear
  this.clear = function() {
    _handleClear({ preventDefault: () => {} });
  };
};

export default dynamicFilterClear;