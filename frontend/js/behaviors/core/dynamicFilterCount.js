// dynamicFilterCount.js
import { triggerCustomEvent } from '@area17/a17-helpers';
import generateComponentId from '../../functions/core/generateComponentId';

const dynamicFilterCount = function(container) {
  const id = generateComponentId();

  container.setAttribute("data-filter-id", id);

  let initialized = false;
  let currentCount = 0;
  let totalCount = 0;

  // Get configuration from data attributes
  const countTarget = container.getAttribute('data-filter-count-target') || container;
  const countTemplate = container.getAttribute('data-filter-count-template') || '{current} of {total}';
  const countLabel = container.getAttribute('data-filter-count-label') || null;
  const showZero = container.getAttribute('data-filter-count-show-zero') !== 'false'; // Default true

  // Find the target element where count will be displayed
  const countElement = typeof countTarget === 'string' ?
    document.querySelector(countTarget) :
    container.querySelector('.js-count-display, .count') || container;

  function _setup() {
    // Store original content as fallback
    if (!countElement.hasAttribute('data-original-content')) {
      countElement.setAttribute('data-original-content', countElement.textContent);
    }
  }

  function _updateCount(visible, total) {
    currentCount = visible;
    totalCount = total;

    // Don't show if count is 0 and showZero is false
    if (currentCount === 0 && !showZero) {
      container.style.display = 'none';
      return;
    } else {
      container.style.display = '';
    }

    // Generate count text using template
    let countText = countTemplate
      .replace('{current}', currentCount)
      .replace('{total}', totalCount)
      .replace('{visible}', currentCount); // Alternative alias

    // Handle singular/plural if specified in template
    if (countTemplate.includes('{item}')) {
      const itemText = currentCount === 1 ? 'item' : 'items';
      countText = countText.replace('{item}', itemText);
    }

    if (countTemplate.includes('{result}')) {
      const resultText = currentCount === 1 ? 'result' : 'results';
      countText = countText.replace('{result}', resultText);
    }

    // Update the display
    countElement.textContent = countText;

    // Add CSS classes for styling hooks
    countElement.classList.toggle('has-results', currentCount > 0);
    countElement.classList.toggle('no-results', currentCount === 0);
    countElement.classList.toggle('filtered', currentCount !== totalCount);
  }

  function _requestCount() {
    // Request current count from the filter system
    triggerCustomEvent(document, 'filter:requestCount', {
      id: id,
      callback: (countData) => {
        if (countData) {
          _updateCount(countData.visible, countData.total);
        }
      }
    });
  }

  function _filterRegister() {
    // Register this component with the filter system
    triggerCustomEvent(document, 'filter:register', {
      id: id,
      parameter: 'count',
      values: ['display'],
      label: countLabel,
      persist: false // Count displays are never persistent
    });
  }

  function _handleFilterUpdate() {
    // Request updated count whenever filters change
    setTimeout(_requestCount, 50); // Small delay to ensure filtering is complete
  }

  function _init() {
    _setup();
    _filterRegister();

    // Listen for filter events to update count
    document.addEventListener('filter:init', _filterRegister);
    document.addEventListener('filter:updated', _handleFilterUpdate);
    document.addEventListener('filter:castUpdate', _handleFilterUpdate);

    // Listen for direct count updates
    document.addEventListener('filter:countUpdate', function(event) {
      if (event.data && (event.data.id === id || event.data.target === 'all')) {
        _updateCount(event.data.visible, event.data.total);
      }
    });

    // Initial count request
    setTimeout(_requestCount, 100);

    initialized = true;
  }

  this.destroy = function() {
    document.removeEventListener('filter:init', _filterRegister);
    document.removeEventListener('filter:updated', _handleFilterUpdate);
    document.removeEventListener('filter:castUpdate', _handleFilterUpdate);
    document.removeEventListener('filter:countUpdate', null);

    // Restore original content
    const originalContent = countElement.getAttribute('data-original-content');
    if (originalContent) {
      countElement.textContent = originalContent;
    }
  };

  this.init = function() {
    if (!initialized) {
      _init();
    }
  };

  // Expose method to manually update count
  this.updateCount = function(visible, total) {
    _updateCount(visible, total);
  };

  // Expose method to get current counts
  this.getCounts = function() {
    return {
      current: currentCount,
      total: totalCount,
      visible: currentCount
    };
  };

  // Expose method to refresh count
  this.refresh = function() {
    _requestCount();
  };
};

export default dynamicFilterCount;