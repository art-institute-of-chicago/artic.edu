// dynamicFilter.js
import { forEach, triggerCustomEvent } from "@area17/a17-helpers";
import getStringSimilarity from '../../functions/core/getStringSimilarity';


const dynamicFilter = function(container) {
  const listingContainer = container.querySelector('[data-filter-target]');
  let listingItems = listingContainer ? listingContainer.querySelectorAll('.m-listing') : [];

  let setup = false; // State tracking of if setup is done so we don't reflow calling and looping the components
  let registeredParameters = []; // Parameters pulled from components to evaluate and update
  let noResultsElement = null; // Element to show when no results are found
  let castParameters = [];

  // Helper function to refresh the current listingItems
  function refreshListingItems() {
    if (listingContainer) {
      listingItems = listingContainer.querySelectorAll('.m-listing');
    }
  }

  function initFromUrl() {
    const url = new URL(window.location.href);
    registeredParameters.forEach(item => {
      const paramValue = url.searchParams.get(item.parameter);

      if (paramValue !== null || paramValue == "" || typeof paramValue == "number") {
        castParameters.push({
          id: item.id,
          parameter: item.parameter,
          value: paramValue
        });
      }
    });

    if (!url.searchParams.get('filter')) {
      url.searchParams.set('filter', 'all');
      window.history.pushState({}, '', url);
    }

    if (!url.searchParams.get('page')) {
      url.searchParams.set('page', 1);
      window.history.pushState({}, '', url);
    }

    // Sort the cast parameters to ensure they're processed in the right order:
    // 1. filter (categories) first
    // 2. search second
    // 3. sort last
    if (castParameters.length > 0) {
      const parameterPriority = {
        'filter': 1,
        'search': 2,
        'sort': 3,
        'paginate': 4,
        'page': 5
      };

      // Sort the parameters based on priority
      castParameters.sort((a, b) => {
        const priorityA = parameterPriority[a.parameter] || 999; // Default high number for unknown parameters
        const priorityB = parameterPriority[b.parameter] || 999;
        return priorityA - priorityB;
      });

      // Apply all filters at once instead of individually
      applyAllFilters(castParameters);

      // Update the UI to reflect the filter state for each parameter
      castParameters.forEach(item => {
        castFilterUpdate(item.id, item.parameter, item.value);
      });

      // Scroll to container after all filters are applied
      window.requestAnimationFrame(() => {
        window.scrollTo({
          top: container.offsetTop - 200,
          behavior: 'smooth'
        });

        triggerCustomEvent(document, 'resized');
      });
    }

    setup = true;
  }

  function castFilterUpdate(id, parameter, value) {
    triggerCustomEvent(document, 'filter:castUpdate', {
      id: id,
      parameter: parameter,
      value: value,
    });
  }

  function updateFilter(parameter, value) {
    const url = new URL(window.location.href);

    // Reset page to 1 when any filter other than 'page' is changed
    if (parameter !== 'page') {
        url.searchParams.set('page', 1);
    }

    if (!parameter) {
        applyAllFilters([{parameter: 'filter', value: 'all'}, {parameter: 'page', value: 1}]);
        initFromUrl();
        return;
    }

    // If value is undefined, null, empty string, or setup is false, remove the parameter
    if (value === undefined || value === null || value === '' || !setup) {
        url.searchParams.delete(parameter);

        // Reset page to 1 when removing a filter
        if (parameter !== 'page') {
            url.searchParams.set('page', 1);
        }

        window.history.pushState({}, '', url);

        // Get all remaining active filters from URL
        const activeFilters = getActiveFiltersFromURL();
        applyAllFilters(activeFilters);
    } else {
        // Get the current value (if any)
        const currentValue = url.searchParams.get(parameter);

        // If the current value is the same as the new value, remove it (toggle behavior)
        if (currentValue === value) {
            url.searchParams.delete(parameter);

            // Reset page to 1 when toggling off a filter
            if (parameter !== 'page') {
                url.searchParams.set('page', 1);
            }
        } else {
            // Otherwise set the new value (replaces any existing value)
            url.searchParams.set(parameter, value);

            // Reset page to 1 when changing a filter value
            if (parameter !== 'page') {
                url.searchParams.set('page', 1);
            }
        }

        window.history.pushState({}, '', url);

        // Get all active filters from URL after update
        const activeFilters = getActiveFiltersFromURL();
        applyAllFilters(activeFilters);
    }
}

  // Helper function to get all active filters from URL
  function getActiveFiltersFromURL() {
    const url = new URL(window.location.href);
    const activeFilters = [];

    // Always include 'filter' param (default to 'all' if not present)
    const filterValue = url.searchParams.get('filter') || 'all';
    activeFilters.push({parameter: 'filter', value: filterValue});

    // Check for search parameter
    const searchValue = url.searchParams.get('search');
    if (searchValue) {
      activeFilters.push({parameter: 'search', value: searchValue});
    }

    // Check for sort parameter
    const sortValue = url.searchParams.get('sort');
    if (sortValue) {
      activeFilters.push({parameter: 'sort', value: sortValue});
    }

    const pageValue = url.searchParams.get('page');
    if (pageValue) {
      activeFilters.push({parameter: 'page', value: pageValue});
    }

    return activeFilters;
  }

  // Apply all filters in the correct order
  function applyAllFilters(filters) {
    // Refresh the listing items first to get the current state
    refreshListingItems();

    // First, reset all items to visible
    listingItems.forEach(item => {
      item.style.display = '';
    });

    // Extract sort and page filters
    const sortFilter = filters.find(f => f.parameter === 'sort');
    const pageFilter = filters.find(f => f.parameter === 'page');

    // Filter out sort and page filters for initial processing
    const initialFilters = filters.filter(f => f.parameter !== 'sort' && f.parameter !== 'page');

    // Apply category and search filters first
    initialFilters.forEach(filter => {
      filterItems(filter.parameter, filter.value);
      // Refresh listing items after each filter
      refreshListingItems();
    });

    // Apply sort filter if present
    if (sortFilter) {
      filterItems(sortFilter.parameter, sortFilter.value);
      // Refresh listing items after sorting
      refreshListingItems();
    }

    // Apply pagination last if present
    if (pageFilter) {
      filterItems(pageFilter.parameter, pageFilter.value);
      // Refresh listing items after pagination
      refreshListingItems();
    }

    // Check for no results after all filters are applied
    checkForNoResults();
  }

  // Helper function to check if there are any visible results
  function checkForNoResults() {
    if (!listingContainer) return;

    // Count visible items
    const visibleItems = Array.from(listingItems).filter(item =>
      item.style.display !== 'none'
    );

    // If no visible items, show the "no results" message
    if (visibleItems.length === 0) {
      // Create the no results element if it doesn't exist
      if (!noResultsElement) {
        noResultsElement = document.createElement('div');
        noResultsElement.className = 'm-no-results';
        noResultsElement.innerHTML = '<h2 class="title f-list-3">Sorry, we couldn\'t find any results matching your criteria.</h2>';
      }

      // Only append if it's not already in the DOM
      if (!noResultsElement.parentNode) {
        listingContainer.appendChild(noResultsElement);
      }
    } else {
      // Remove the no results message if it exists and there are results
      if (noResultsElement && noResultsElement.parentNode) {
        noResultsElement.parentNode.removeChild(noResultsElement);
      }
    }
  }

  function filterItems(parameter, value) {
    if (!listingItems.length) {
      return;
    }

    if (parameter) {
      switch(parameter) {
        case "filter":
          // Filter by category
          if (value !== 'all') {
            const normalizedValue = value.toLowerCase().replace(/[_\s-]+/g, '-');

            // Loop through all items
            listingItems.forEach(item => {
              // Skip already hidden items
              if (item.style.display === 'none') return;

              const filterValues = item.getAttribute('data-filter-values');
              let showItem = false;

              if (filterValues) {
                // Parse the item's filter values
                const itemFilterValues = filterValues.split(',').map(val => val.trim().toLowerCase());

                // Check if this item matches the active filter
                for (const itemValue of itemFilterValues) {
                  const normalizedItemValue = itemValue.replace(/[_\s-]+/g, '-');
                  if (normalizedItemValue === normalizedValue) {
                    showItem = true;
                    break;
                  }
                }
              }

              // Show or hide item
              if (!showItem) {
                item.style.display = 'none';
              }
            });
          }
          break;

        case "sort":
          // Sort items
          if (!listingContainer) break;

          // Only collect items that are currently visible (not display:none)
          const itemsArray = Array.from(listingItems).filter(item => {
            return item.style.display !== 'none';
          });

          const container = listingItems.length > 0 ? listingItems[0].parentNode : null;
          if (!container) break;

          // Sort based on value parameter
          switch(value) {
            case "titledesc":
              itemsArray.sort((a, b) => {
                const titleA = a.getAttribute('data-filter-title') || a.textContent.trim();
                const titleB = b.getAttribute('data-filter-title') || b.textContent.trim();
                return titleA.localeCompare(titleB);
              });
              break;
            case "datetimeasc":
              itemsArray.sort((a, b) => {
                const dateStrA = a.getAttribute('data-filter-date') || '';
                const dateStrB = b.getAttribute('data-filter-date') || '';
                // Parse dates from DD-MM-YYYY format
                const [dayA, monthA, yearA] = (dateStrA || '').split('-');
                const [dayB, monthB, yearB] = (dateStrB || '').split('-');
                // Create date objects for comparison
                const dateA = dateStrA ? new Date(yearA, monthA - 1, dayA) : new Date(0);
                const dateB = dateStrB ? new Date(yearB, monthB - 1, dayB) : new Date(0);
                return dateA - dateB;
              });
              break;
            case "datetimedesc":
              itemsArray.sort((a, b) => {
                const dateStrA = a.getAttribute('data-filter-date') || '';
                const dateStrB = b.getAttribute('data-filter-date') || '';
                // Parse dates from DD-MM-YYYY format
                const [dayA, monthA, yearA] = (dateStrA || '').split('-');
                const [dayB, monthB, yearB] = (dateStrB || '').split('-');
                // Create date objects for comparison
                const dateA = dateStrA ? new Date(yearA, monthA - 1, dayA) : new Date(0);
                const dateB = dateStrB ? new Date(yearB, monthB - 1, dayB) : new Date(0);
                return dateB - dateA;
              });
              break;
            case null:
              itemsArray.sort((a, b) => {
                const titleA = a.getAttribute('data-filter-title') || a.textContent.trim();
                const titleB = b.getAttribute('data-filter-title') || b.textContent.trim();
                return titleA.localeCompare(titleB);
              });
          }

          // Reorder without changing visibility
          // This uses the DocumentFragment API for better performance
          const fragment = document.createDocumentFragment();

          // Append to fragment in sorted order
          itemsArray.forEach(item => {
            fragment.appendChild(item);
          });

          // Append fragment to container
          container.appendChild(fragment);

          // Force reflow
          container.offsetHeight;

          // Update the listing items array to reflect the new order
          refreshListingItems();
          break;

        case "search":
          // Search by text
          if (value) {
            const searchText = value.trim();

            // Loop through all items
            listingItems.forEach(item => {
              // Skip already hidden items
              if (item.style.display === 'none') return;

              let showItem = false;

              // First try to get the title from data attribute
              let itemTitle = item.getAttribute('data-filter-title');

              // If no data-title attribute, try to find a title element
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

              if (itemTitle) {
                itemTitle = itemTitle.trim();

                // Exact match
                if (itemTitle.toLowerCase().includes(searchText.toLowerCase())) {
                  showItem = true;
                } else if (searchText.length <= 3) {
                  // For short search terms (2-3 chars), require exact substring match
                  showItem = itemTitle.toLowerCase().includes(searchText.toLowerCase());
                } else {
                  // For longer search terms, use fuzzy matching
                  const words = itemTitle.split(/\s+/);

                  // Check each word
                  for (const word of words) {
                    // Calculate similarity
                    const similarity = getStringSimilarity(word, searchText);

                    // Allow matches with distance less than 1/3 of the search text length
                    if (similarity <= Math.ceil(searchText.length / 3)) {
                      showItem = true;
                      break;
                    }

                    // Also check if any word in the title starts with the search text
                    if (word.toLowerCase().startsWith(searchText.toLowerCase())) {
                      showItem = true;
                      break;
                    }
                  }
                }
              }

              // Hide item if it doesn't match search
              if (!showItem) {
                item.style.display = 'none';
              }
            });
          }
          break;

        case "page":
          if (value) {
              const itemsArray = Array.from(listingItems).filter(item => {
                  return item.style.display !== 'none';
              });
              const pageItemLimit = registeredParameters.find(item => item.parameter === "pageItemLimit");
              const pages = Math.ceil(itemsArray.length / pageItemLimit.value);

              // Calculate current page boundaries
              const currentPage = parseInt(value) || 1;
              const startIndex = (currentPage - 1) * pageItemLimit.value;
              const endIndex = startIndex + pageItemLimit.value;

              // Hide all items first
              itemsArray.forEach(item => {
                  item.style.display = 'none';
              });

              // Show only items for the current page
              for (let i = startIndex; i < endIndex && i < itemsArray.length; i++) {
                  itemsArray[i].style.display = '';
              }

              const totalPages = registeredParameters.find(item => item.parameter === "totalPages");
              totalPages.value = pages;

              triggerCustomEvent(document, "filter:castUpdate", {
                id: totalPages.id,
                parameter: totalPages.parameter,
                value: totalPages.value
              });
          }
          break;

        default:
        // Default case: no filtering
        break;
      }
    }
  }

  function _setup() {
    if (!setup) {
      document.addEventListener('filter:register', _registerComponent);
      triggerCustomEvent(document, 'filter:init');
    }

    document.addEventListener('filter:updated', function(event) {
      updateFilter(event.data.parameter, event.data.value);
    });
  }

  function _registerComponent(event) {
    if (!event || !event.data) {
      return;
    }

    let filterData = event.data;

    registeredParameters.push({
      id: filterData.id,
      parameter: filterData.parameter,
      value: filterData.value !== undefined ? filterData.value : filterData.values
    });

    setup = true;
  }

  function _init() {
    _setup();
    setTimeout(initFromUrl, 200);
    window.addEventListener('popstate', initFromUrl);
  }

  this.destroy = function() {
    window.removeEventListener('popstate', initFromUrl);
    document.removeEventListener('filter:register', _registerComponent);

    if (noResultsElement && noResultsElement.parentNode) {
      noResultsElement.parentNode.removeChild(noResultsElement);
    }
  };

  this.init = function() {
    _init();
  };
};

export default dynamicFilter;