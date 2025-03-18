import { forEach, triggerCustomEvent } from "@area17/a17-helpers";
import { dynamicFilterSetup } from ".";

const dynamicFilter = function(container) {

  // Filter elements
  const filterButtonsContainer = document.querySelector('[data-filter-buttons]');
  const filterButtons = filterButtonsContainer ? filterButtonsContainer.querySelectorAll('[data-button-value]') : [];
  const listingContainer = container.querySelector('[data-filter-target]');
  const filterItems = listingContainer ? listingContainer.querySelectorAll('.m-listing') : [];
  const dropdownList = document.querySelector('[data-dropdown-list]');
  const dropdownItems = dropdownList ? dropdownList.querySelectorAll('[data-button-value]') : [];
  
  let activeFilter = '';
  let activeSearchText = '';
  let lastURLUpdate = 0; // Track last URL update time
  const URL_UPDATE_DEBOUNCE = 300; // Minimum ms between URL updates

  function initFromUrl() {
    const url = new URL(window.location.href);
    
    // Reset active filter
    activeFilter = '';
    activeSearchText = '';
    
    // Get filter from URL parameters
    let filterParam = url.searchParams.get('filter') || '';
    
    if (filterParam) {
      activeFilter = filterParam.split(',')[0].trim();
    }
    
    // Get search text from URL if available
    const searchParam = url.searchParams.get('search');
    if (searchParam) {
      activeSearchText = searchParam;
    }
    
    // If no filter but there's a category, use that
    if (!activeFilter) {
      const categoryParam = url.searchParams.get('category');
      if (categoryParam && categoryParam !== 'all') {
        activeFilter = categoryParam;
      }
    }
    
    // Apply initial active states to primary filter buttons
    if (filterButtonsContainer) {
      // Handle top-level primary filters
      const topLevelItems = filterButtonsContainer.querySelectorAll('[data-button-value]');
      forEach(topLevelItems, function(index, item) {
        const buttonValue = item.getAttribute('data-button-value');
        
        // Check if this button value is our active filter
        if (buttonValue && buttonValue === activeFilter) {
          item.classList.add('s-active');
        } else {
          item.classList.remove('s-active');
        }
      });
    }
    
    // Highlight active dropdown items if it's the active filter
    if (dropdownList) {
      forEach(dropdownItems, function(index, item) {
        const buttonValue = item.getAttribute('data-button-value');
        
        if (buttonValue && buttonValue === activeFilter) {
          item.classList.add('s-active');
        } else {
          item.classList.remove('s-active');
        }
      });
    }
    
    // Apply initial filtering
    filterListingItems(false); // Don't update URL when initializing
  }
  
  function setupEventListeners() {
    document.addEventListener('click', documentClickHandler);
    
    // Listen for any filter changes
    document.addEventListener('filter:updated', function(event) {
      if (event.data) {
        let shouldUpdateURL = true;
        
        // Check if this is a category filter update
        if (event.data.value && event.data.value !== 'all') {
          // Always replace the active filter with the new value
          activeFilter = event.data.value;
          // Reset search when using category filters
          activeSearchText = '';
        }
        
        // Check if this is a search text filter update
        if (event.data.filterText !== undefined) {
          activeSearchText = event.data.filterText;
          // When searching, clear category filter
          if (activeSearchText) {
            activeFilter = '';
            // Deactivate all buttons
            forEach(filterButtons, function(index, item) {
              item.classList.remove('s-active');
            });
            
            // Deactivate all dropdown items
            forEach(dropdownItems, function(index, item) {
              item.classList.remove('s-active');
            });
            
            // Set the "all" button to active if it exists
            if (filterButtonsContainer) {
              const allButton = filterButtonsContainer.querySelector('[data-button-value="all"]');
              if (allButton) {
                allButton.classList.add('s-active');
              }
            }
          }
        }
        
        // Check if the event explicitly says not to update URL
        if (event.data.updateURL === false) {
          shouldUpdateURL = false;
        }
        
        filterListingItems(shouldUpdateURL);
      }
    });
  }
  
  // Update the URL with current filter value and search text
  function updateURL() {
    const now = Date.now();
    
    // Debounce URL updates to prevent Safari rate limiting
    if (now - lastURLUpdate < URL_UPDATE_DEBOUNCE) {
      return;
    }
    
    lastURLUpdate = now;
    
    const url = new URL(window.location.href);
    
    if (activeFilter) {
      url.searchParams.set('filter', activeFilter);
    } else {
      url.searchParams.delete('filter');
      url.searchParams.delete('type');
      url.searchParams.delete('category');
    }
    
    if (activeSearchText) {
      url.searchParams.set('search', activeSearchText);
    } else {
      url.searchParams.delete('search');
    }
    
    window.history.pushState({}, '', url.toString());
  }
  
  // Set a filter button and update the URL
  function toggleFilterButton(buttonElement, value) {
    // Special case for "all" - clear filter
    if (value === 'all') {
      // Remove active class from all buttons
      forEach(filterButtons, function(index, item) {
        item.classList.remove('s-active');
      });
      
      // Remove active class from all dropdown items
      forEach(dropdownItems, function(index, item) {
        item.classList.remove('s-active');
      });
      
      // Set active class just on the "all" button
      buttonElement.classList.add('s-active');
      
      // Clear filter
      activeFilter = '';
    } else {
      // If clicking the same filter, toggle it off
      if (value === activeFilter) {
        activeFilter = '';
        buttonElement.classList.remove('s-active');
        
        // Set the "all" button to active if it exists
        if (filterButtonsContainer) {
          const allButton = filterButtonsContainer.querySelector('[data-button-value="all"]');
          if (allButton) {
            allButton.classList.add('s-active');
          }
        }
      } 
      // Otherwise set it as the only active filter
      else {
        // First, deactivate all buttons
        forEach(filterButtons, function(index, item) {
          item.classList.remove('s-active');
        });
        
        // Deactivate all dropdown items
        forEach(dropdownItems, function(index, item) {
          item.classList.remove('s-active');
        });
        
        // Set new active filter
        activeFilter = value;
        buttonElement.classList.add('s-active');
      }
    }
    
    // When toggling category filter, clear search text
    activeSearchText = '';
    
    // Filter items and update URL
    filterListingItems(true);
  }
  
  // Calculate string similarity for fuzzy search (Levenshtein distance)
  function getStringSimilarity(a, b) {
    if (a.length === 0) return b.length;
    if (b.length === 0) return a.length;
    
    a = a.toLowerCase();
    b = b.toLowerCase();
    
    const matrix = [];
    
    // Initialize matrix
    for (let i = 0; i <= b.length; i++) {
      matrix[i] = [i];
    }
    
    for (let i = 0; i <= a.length; i++) {
      matrix[0][i] = i;
    }
    
    // Fill matrix
    for (let i = 1; i <= b.length; i++) {
      for (let j = 1; j <= a.length; j++) {
        if (b.charAt(i - 1) === a.charAt(j - 1)) {
          matrix[i][j] = matrix[i - 1][j - 1];
        } else {
          matrix[i][j] = Math.min(
            matrix[i - 1][j - 1] + 1, // substitution
            matrix[i][j - 1] + 1,     // insertion
            matrix[i - 1][j] + 1      // deletion
          );
        }
      }
    }
    
    // Return similarity score (lower is better)
    return matrix[b.length][a.length];
  }
  
  // Check if an item's title is a close match for the search text
  function isSearchMatch(item, searchText) {
    if (!searchText) return true;
    
    // First try to get the title from data attribute
    let itemTitle = item.getAttribute('data-title');
    
    // If no data-title attribute, try to find a title element within the item
    if (!itemTitle) {
      const titleElement = item.querySelector('.title, h2, h3, h4');
      if (titleElement) {
        itemTitle = titleElement.textContent;
      }
    }
    
    // If still no title found, use any text content
    if (!itemTitle) {
      itemTitle = item.textContent;
    }
    
    if (!itemTitle) return false;
    
    itemTitle = itemTitle.trim();
    searchText = searchText.trim();
    
    // Exact match
    if (itemTitle.toLowerCase().includes(searchText.toLowerCase())) {
      return true;
    }
    
    // For short search terms (2-3 chars), require exact substring match
    if (searchText.length <= 3) {
      return itemTitle.toLowerCase().includes(searchText.toLowerCase());
    }
    
    // For longer search terms, use fuzzy matching
    const words = itemTitle.split(/\s+/);
    for (const word of words) {
      // Calculate similarity - lower score is better
      const similarity = getStringSimilarity(word, searchText);
      // Allow matches with distance less than 1/3 of the search text length
      if (similarity <= Math.ceil(searchText.length / 3)) {
        return true;
      }
    }
    
    // Also check if any word in the title starts with the search text
    for (const word of words) {
      if (word.toLowerCase().startsWith(searchText.toLowerCase())) {
        return true;
      }
    }
    
    return false;
  }
  
  // Filter listing items based on active filter and search text
  function filterListingItems(shouldUpdateURL = true) {
    if (!filterItems.length) {
      return;
    }
    
    let visibleCount = 0;
    
    // If no active filter and no search text, show everything
    if (!activeFilter && !activeSearchText) {
      forEach(filterItems, function(index, item) {
        item.classList.remove('s-hidden');
        item.style.display = '';
        visibleCount++;
      });
      
      // Trigger filter:reset event when there are no active filters
      triggerCustomEvent(document, 'filter:reset');
      
      // Also trigger filter:updated event to maintain compatibility
      triggerCustomEvent(document, 'filter:updated', { 
        activeFilter, 
        activeSearchText,
        updateURL: false // Prevent additional URL updates from this event
      });
      
      // Trigger layout:refresh event for masonry layout
      if (typeof(window.A17) !== 'undefined' && window.A17.Helpers && window.A17.Helpers.triggerCustomEvent) {
        window.A17.Helpers.triggerCustomEvent(document, 'layout:refresh');
      }
      
      // Only update URL if explicitly requested
      if (shouldUpdateURL) {
        updateURL();
      }
      
      return;
    }
    
    forEach(filterItems, function(index, item) {
      const filterValues = item.getAttribute('data-filter-values');
      
      let showItem = true;
      
      // Check category filter first
      if (activeFilter && filterValues) {
        // Parse the item's filter values
        const itemFilterValues = filterValues.split(',').map(val => val.trim().toLowerCase());
        const normalizedActiveFilter = activeFilter.toLowerCase().replace(/[_\s-]+/g, '-');
        
        // Check if this item matches the active filter
        showItem = false;
        for (const itemValue of itemFilterValues) {
          const normalizedItemValue = itemValue.replace(/[_\s-]+/g, '-');
          
          if (normalizedItemValue === normalizedActiveFilter) {
            showItem = true;
            break;
          }
        }
      }
      
      // If item passes category filter (or no category filter active), 
      // then check search text match
      if (showItem && activeSearchText) {
        showItem = isSearchMatch(item, activeSearchText);
      }
      
      // Show or hide item
      if (showItem) {
        item.classList.add('s-positioned');
        item.style.transition = 'opacity 1s ease, top .5s ease, left .5s ease';
        item.style.opacity = "0";
        item.style.display = '';
        item.style.opacity = "1";
        visibleCount++;
      } else {
        item.classList.remove('s-positioned');
        item.style.display = 'none';
      }
    });
    
    // Trigger custom event for other components to react
    triggerCustomEvent(document, 'filter:updated', { 
      activeFilter, 
      activeSearchText,
      updateURL: false // Prevent additional URL updates from this event
    });
    
    // If you're using a masonry layout, you might need to trigger a reflow
    if (typeof(window.A17) !== 'undefined' && window.A17.Helpers && window.A17.Helpers.triggerCustomEvent) {
      window.A17.Helpers.triggerCustomEvent(document, 'layout:refresh');
    }
    
    // Only update URL if explicitly requested
    if (shouldUpdateURL) {
      updateURL();
    }
  }
  
  function _init() {
    initFromUrl();
    setupEventListeners();
    
    window.addEventListener('popstate', function() {
      initFromUrl();
    });
  }
  
  // Store document click handler for cleanup
  const documentClickHandler = function(event) {
    // Find if the click is on or within an li with data-button-value
    const li = event.target.closest('[data-button-value]');
    
    if (li) {
      event.preventDefault();
      
      const buttonValue = li.getAttribute('data-button-value');
      
      if (buttonValue) {
        toggleFilterButton(li, buttonValue);
      }
    }
  };

  this.destroy = function() {
    // Remove document event listeners
    document.removeEventListener('click', documentClickHandler);
    window.removeEventListener('popstate', initFromUrl);
  };
  
  this.init = function() {
    _init();
  };
};

export default dynamicFilter;