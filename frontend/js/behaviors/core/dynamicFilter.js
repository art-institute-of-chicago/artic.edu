// dynamicFilter.js
import { forEach, triggerCustomEvent } from "@area17/a17-helpers";
import getStringSimilarity from '../../functions/core/getStringSimilarity';


const dynamicFilter = function(container) {
  const listingContainer = container.querySelector('[data-filter-target]');
  const listingItems = listingContainer ? listingContainer.querySelectorAll('.m-listing') : [];

  let setup = false; // State tracking of if setup is done so we don't reflow calling and looping the components
  let registeredParameters = []; // Parameters pulled from components to evaluate and update
  
  function initFromUrl() {
    const url = new URL(window.location.href);
    let castParameters = [];
    
    console.log('init from url');
    console.log(registeredParameters);

    registeredParameters.forEach(item => {
      const paramValue = url.searchParams.get(item.parameter);

      if (paramValue !== null && (item.value.includes(paramValue) || item.value === "")) {
        castParameters.push({
          id: item.id,
          parameter: item.parameter,
          value: paramValue
        });
      } else {
        url.searchParams.set('filter', 'all');
        window.history.pushState({}, '', url);
      }
    });

    if (castParameters.length > 0) {
      castParameters.forEach(item => {
        castFilterUpdate(item.id, item.parameter, item.value);
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
    console.log('update filter: param: ' + parameter + ' value: ' + value);
    const url = new URL(window.location.href);
    
    if (!parameter) {
      filterItems('filter', 'all');
    };
    
    // If value is undefined, null, empty string, or setup is false, remove the parameter
    if (value === undefined || value === null || value === '' || !setup) {
      console.log('no value ' + value);
      url.searchParams.delete(parameter);
      window.history.pushState({}, '', url);
      filterItems();
    } else {
      // Get the current value (if any)
      const currentValue = url.searchParams.get(parameter);
      
      // If the current value is the same as the new value, remove it (toggle behavior)
      if (currentValue === value) {
        url.searchParams.delete(parameter);
      } else {
        // Otherwise set the new value (replaces any existing value)
        url.searchParams.set(parameter, value);
      }
      
      window.history.pushState({}, '', url);
      filterItems(parameter, value);
      console.log('filter items?: ' + parameter + ' ' + value);
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
              if (showItem) {
                item.style.display = '';
              } else {
                item.style.display = 'none';
              }
            });
          } else {
            // No filter value, show all items
            listingItems.forEach(item => {
              item.style.display = '';
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
            case "title::desc":
              itemsArray.sort((a, b) => {
                const titleA = a.getAttribute('data-filter-title') || a.textContent.trim();
                const titleB = b.getAttribute('data-filter-title') || b.textContent.trim();
                return titleA.localeCompare(titleB);
              });
              break;
            case "datetime::asc":
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
            case "datetime::desc":
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
          break;

        case "search":
          // Search by text
          if (value) {
            const searchText = value.trim();
            
            // Loop through all items
            listingItems.forEach(item => {
              let showItem = false;
              
              // First try to get the title from data attribute
              let itemTitle = item.getAttribute('data-title');
              
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
              
              // Show or hide item
              if (showItem) {
                item.style.display = '';
              } else {
                item.style.display = 'none';
              }
            });
          } else {
            // No search value, show all items
            listingItems.forEach(item => {
              item.style.display = '';
            });
          }
          break;
          
        default:
          // Default case: show all items
          listingItems.forEach(item => {
            item.style.display = '';
          });
      }
    }
  }

  function resetFilter() {
    triggerCustomEvent(document, 'filter:reset');

    document.querySelector('[data-filter-default]').classList.add('s-active');
  }

  function _setup() {
    console.log('Setup called, current status:', setup);
    if (!setup) {
      console.log('Adding filter:register event listener');
      document.addEventListener('filter:register', _registerComponent);
      
      console.log('Triggering filter:init event');
      triggerCustomEvent(document, 'filter:init');
    }

    document.addEventListener('filter:updated', function(event) {
      updateFilter(event.data.parameter, event.data.value);
      console.log(event);
    });
  }

  function _registerComponent(event) {
    console.log('A component wants to register!')
    if (!event || !event.data) {
      console.log('Event or event.detail is missing:', event);
      return;
    }
    
    let filterData = event.data;
    console.log('Filter data received:', filterData);
    
    registeredParameters.push({
      id: filterData.id,
      parameter: filterData.parameter,
      value: filterData.value !== undefined ? filterData.value : filterData.values
    });
    
    setup = true;
    console.log('Setup status: '+ setup);
    console.log('Registration complete! Params:', registeredParameters);
  }

  function _init() {
    _setup();
    setTimeout(initFromUrl, 200)
    window.addEventListener('popstate', initFromUrl);
  } 

  this.destroy = function() {
    window.removeEventListener('popstate', initFromUrl);
    document.removeEventListener('filter:register', _registerComponent);
  };

  this.init = function() {
    _init();
  };
};

export default dynamicFilter;