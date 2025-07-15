import { forEach, triggerCustomEvent } from "@area17/a17-helpers";
import getStringSimilarity from '../../functions/core/getStringSimilarity';

const dynamicFilter = function(container) {
  const listingContainer = container.querySelector('[data-filter-target]');
  let listingItems = listingContainer ? listingContainer.querySelectorAll('.m-listing') : [];

  let setup = false;
  let registeredParameters = [];
  let noResultsElement = null;
  let castParameters = [];
  let isClearing = false;

  // Check if the container has persistence enabled
  const isPersistenceEnabled = container.hasAttribute('data-filter-persist');

  function refreshListingItems() {
    if (listingContainer) {
      listingItems = listingContainer.querySelectorAll('.m-listing');
    }
  }

  function getVisibleItemsCount() {
    if (!listingItems.length) return { visible: 0, total: 0 };

    const visibleItems = Array.from(listingItems).filter(item =>
      item.style.display !== 'none'
    );

    return {
      visible: visibleItems.length,
      total: listingItems.length
    };
  }

  function clearFilters() {
    console.log('Clearing all filters');

    // Set clearing flag to prevent components from interfering
    isClearing = true;

    const url = new URL(window.location.href);
    const systemParams = ['page', 'filter', 'clear', 'count', 'pageItemLimit', 'totalPages'];

    registeredParameters.forEach(param => {
      if (systemParams.includes(param.parameter)) return;

      url.searchParams.delete(param.parameter);
      if (param.label && param.label !== param.parameter) {
        url.searchParams.delete(param.label);
      }
    });

    // Also clear any remaining filter-related parameters that might exist
    // This handles cases where the URL might have extra parameters
    const allParams = Array.from(url.searchParams.keys());
    allParams.forEach(key => {
      if (!systemParams.includes(key) && key !== 'filter') {
        // Check if this parameter belongs to any registered component
        const belongsToComponent = registeredParameters.some(param =>
          param.parameter === key || param.label === key
        );
        if (belongsToComponent) {
          url.searchParams.delete(key);
        }
      }
    });

    // Reset parameters
    url.searchParams.set('filter', 'all');
    url.searchParams.set('page', '1');
    window.history.pushState({}, '', url);

    console.log('URL after clear:', url.href);

    const activeFilters = getActiveFiltersFromURL();
    applyAllFilters(activeFilters);

    triggerCustomEvent(document, 'filter:cleared');

    setTimeout(() => {
      initFromUrl();
      isClearing = false;
    }, 10);

    console.log('Filter clearing complete');
  }

  function initFromUrl() {
    const url = new URL(window.location.href);
    let urlModified = false;

    // Check if we have any filter-related parameters (either 'filter' or any registered labels)
    const hasFilterParameters = url.searchParams.get('filter') ||
      registeredParameters.some(item => url.searchParams.get(item.label));

    // Only add filter=all if there are no filter-related parameters at all
    if (!hasFilterParameters) {
      url.searchParams.set('filter', 'all');
      urlModified = true;
    }

    if (!url.searchParams.get('page')) {
      url.searchParams.set('page', 1);
      urlModified = true;
    }

    castParameters = [];

    registeredParameters.forEach(item => {
      let paramValue = url.searchParams.get(item.parameter);
      let labelValue = url.searchParams.get(item.label);

      if (labelValue !== null && labelValue !== undefined) {
        castParameters.push({
          id: item.id,
          parameter: item.parameter,
          value: labelValue,
          label: item.label,
          originalLabel: true,
          persist: item.persist || false
        });
      }
      else if (paramValue !== null && paramValue !== undefined) {
        castParameters.push({
          id: item.id,
          parameter: item.parameter,
          value: paramValue,
          label: item.label,
          persist: item.persist || false
        });
      }
    });

    // Only modify URL to clean up if we added missing parameters
    if (urlModified) {
      window.history.pushState({}, '', url);
    }

    if (castParameters.length > 0) {
      const parameterPriority = {
        'filter': 1,
        'search': 2,
        'sort': 3,
        'paginate': 4,
        'page': 5
      };

      castParameters.sort((a, b) => {
        const priorityA = parameterPriority[a.parameter] || 999;
        const priorityB = parameterPriority[b.parameter] || 999;
        return priorityA - priorityB;
      });

      applyAllFilters(castParameters);

      castParameters.forEach(item => {
        castFilterUpdate(
          item.id,
          item.parameter,
          item.label,
          item.value,
          item.originalLabel || false
        );
      });

      triggerCustomEvent(document, 'resized');

      if (url.searchParams.get('filter') !== 'all' && url.searchParams.get('page') !== '1') {
        window.requestAnimationFrame(() => {
          window.scrollTo({
            top: container.offsetTop - 200,
            behavior: 'smooth'
          });
        });
      }
    }

    setup = true;
  }

  function castFilterUpdate(id, parameter, label, value, isLabelCast = false) {
    triggerCustomEvent(document, 'filter:castUpdate', {
      id: id,
      parameter: parameter,
      value: value,
      label: label,
      isLabelCast: isLabelCast
    });
  }

  function updateFilter(parameter, value, useLabel = false, label = null, forceClear = false) {
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

    // Enhanced parameter details determination
    let parameterDetails = null;

    if (useLabel && label) {
        parameterDetails = registeredParameters.find(item => item.label === label);
    } else if (label && !useLabel) {
        const labelExists = registeredParameters.find(item => item.label === label);
        if (labelExists) {
            parameterDetails = labelExists;
        } else {
            parameterDetails = registeredParameters.find(item => item.parameter === parameter);
        }
    } else {
        parameterDetails = registeredParameters.find(item => item.parameter === parameter);
    }

    if (!parameterDetails) {
        parameterDetails = registeredParameters.find(item =>
            item.parameter === parameter || item.label === parameter
        );
    }

    console.log('Parameter Details:', {
        parameter,
        value,
        useLabel,
        label,
        parameterDetails,
        hasLabel: parameterDetails?.label ? true : false,
        actualParameter: parameterDetails?.parameter,
        willUseLabel: useLabel && parameterDetails?.label,
        isPersistent: parameterDetails?.persist || false,
        forceClear
    });

    const urlParam = (useLabel && parameterDetails && parameterDetails.label)
      ? parameterDetails.label
      : parameter;

    // Check if this is a persistent filter
    const isPersistent = parameterDetails?.persist || false;

    if (value === undefined || value === null || value === '' || !setup) {
        // For persistent filters, only remove if explicitly toggled off or forced clear
        if (isPersistent && isPersistenceEnabled && !forceClear) {
            // Don't remove persistent filters automatically, but still apply current filters
            const activeFilters = getActiveFiltersFromURL();
            applyAllFilters(activeFilters);
            return;
        }

        // Clear the filter from URL
        url.searchParams.delete(parameter);
        if (parameterDetails && parameterDetails.label) {
            url.searchParams.delete(parameterDetails.label);
        }

        if (parameter !== 'page') {
            url.searchParams.set('page', 1);
        }

        window.history.pushState({}, '', url);

        const activeFilters = getActiveFiltersFromURL();
        applyAllFilters(activeFilters);
    } else {
        const currentValue = url.searchParams.get(urlParam);

        // Handle toggle behavior for persistent vs non-persistent filters
        if (currentValue === value) {
            // Toggle off - remove from URL
            url.searchParams.delete(urlParam);

            if (urlParam !== parameter) {
                url.searchParams.delete(parameter);
            }

            if (parameter !== 'page') {
                url.searchParams.set('page', 1);
            }
        } else {
            // Set new value
            url.searchParams.set(urlParam, value);

            if (parameter !== 'page') {
                url.searchParams.set('page', 1);
            }
        }

        window.history.pushState({}, '', url);

        const activeFilters = getActiveFiltersFromURL();
        applyAllFilters(activeFilters);
    }
  }

  function getActiveFiltersFromURL() {
    const url = new URL(window.location.href);
    const activeFilters = [];
    const processedComponents = new Set(); // Track which components we've already processed

    registeredParameters.forEach(item => {
      if (processedComponents.has(item.id)) return;

      const paramValue = url.searchParams.get(item.parameter);
      const labelValue = url.searchParams.get(item.label);

      // Prioritize label value over parameter value if both exist
      if (labelValue !== null && labelValue !== undefined) {
        activeFilters.push({
          parameter: item.parameter,
          value: labelValue,
          label: item.label,
          originalLabel: true,
          persist: item.persist || false
        });
        processedComponents.add(item.id);
      } else if (paramValue !== null && paramValue !== undefined) {
        activeFilters.push({
          parameter: item.parameter,
          value: paramValue,
          label: item.label,
          persist: item.persist || false
        });
        processedComponents.add(item.id);
      }
    });

    if (!activeFilters.some(f => f.parameter === 'filter')) {
      activeFilters.push({parameter: 'filter', value: 'all'});
    }

    if (!activeFilters.some(f => f.parameter === 'page')) {
      activeFilters.push({parameter: 'page', value: '1'});
    }

    return activeFilters;
  }

  function applyAllFilters(filters) {
    refreshListingItems();

    listingItems.forEach(item => {
      item.style.display = '';
    });

    const sortFilter = filters.find(f => f.parameter === 'sort');
    const pageFilter = filters.find(f => f.parameter === 'page');

    const initialFilters = filters.filter(f => f.parameter !== 'sort' && f.parameter !== 'page');

    initialFilters.forEach(filter => {
      filterItems(filter.parameter, filter.value);
      refreshListingItems();
    });

    if (sortFilter) {
      filterItems(sortFilter.parameter, sortFilter.value);
      refreshListingItems();
    }

    if (pageFilter) {
      filterItems(pageFilter.parameter, pageFilter.value);
      refreshListingItems();
    }

    checkForNoResults();

    // Update count displays
    const counts = getVisibleItemsCount();
    triggerCustomEvent(document, 'filter:countUpdate', {
      target: 'all',
      visible: counts.visible,
      total: counts.total
    });
  }

  function checkForNoResults() {
    if (!listingContainer) return;

    const visibleItems = Array.from(listingItems).filter(item =>
      item.style.display !== 'none'
    );

    if (visibleItems.length === 0) {
      if (!noResultsElement) {
        noResultsElement = document.createElement('div');
        noResultsElement.className = 'm-no-results';
        noResultsElement.innerHTML = '<h2 class="title f-list-3">Sorry, we couldn\'t find any results matching your criteria.</h2>';
      }

      if (!noResultsElement.parentNode) {
        listingContainer.appendChild(noResultsElement);
      }
    } else {
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
          if (value !== 'all') {
            const normalizedValue = value.toLowerCase().replace(/[_\s-]+/g, '-');
            listingItems.forEach(item => {
              if (item.style.display === 'none') return;
              const filterValues = item.getAttribute('data-filter-values');
              let showItem = false;
              if (filterValues) {
                const itemFilterValues = filterValues.split(',').map(val => val.trim().toLowerCase());
                for (const itemValue of itemFilterValues) {
                  const normalizedItemValue = itemValue.replace(/[_\s-]+/g, '-');
                  if (normalizedItemValue === normalizedValue) {
                    showItem = true;
                    break;
                  }
                }
              }
              if (!showItem) {
                item.style.display = 'none';
              }
            });
          }

          listingContainer.style.display = 'none';
          listingContainer.offsetHeight; // Trigger reflow
          listingContainer.style.display = '';

          break;

        case "sort":
          if (!listingContainer) break;

          const itemsArray = Array.from(listingItems).filter(item => {
            return item.style.display !== 'none';
          });

          const container = listingItems.length > 0 ? listingItems[0].parentNode : null;
          if (!container) break;

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
                const [dayA, monthA, yearA] = (dateStrA || '').split('-');
                const [dayB, monthB, yearB] = (dateStrB || '').split('-');
                const dateA = dateStrA ? new Date(yearA, monthA - 1, dayA) : new Date(0);
                const dateB = dateStrB ? new Date(yearB, monthB - 1, dayB) : new Date(0);
                return dateA - dateB;
              });
              break;
            case "datetimedesc":
              itemsArray.sort((a, b) => {
                const dateStrA = a.getAttribute('data-filter-date') || '';
                const dateStrB = b.getAttribute('data-filter-date') || '';
                const [dayA, monthA, yearA] = (dateStrA || '').split('-');
                const [dayB, monthB, yearB] = (dateStrB || '').split('-');
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

          const fragment = document.createDocumentFragment();
          itemsArray.forEach(item => {
            fragment.appendChild(item);
          });
          container.appendChild(fragment);
          container.offsetHeight;
          refreshListingItems();
          break;

        case "search":
          if (value) {
            const searchText = value.trim();

            listingItems.forEach(item => {
              if (item.style.display === 'none') return;

              let showItem = false;
              let itemTitle = item.getAttribute('data-filter-title');

              if (!itemTitle) {
                const titleElement = item.querySelector('.title, h2, h3, h4');
                if (titleElement) {
                  itemTitle = titleElement.textContent;
                }
              }

              if (!itemTitle) {
                itemTitle = item.textContent;
              }

              if (itemTitle) {
                itemTitle = itemTitle.trim();

                if (itemTitle.toLowerCase().includes(searchText.toLowerCase())) {
                  showItem = true;
                } else if (searchText.length <= 3) {
                  showItem = itemTitle.toLowerCase().includes(searchText.toLowerCase());
                } else {
                  const words = itemTitle.split(/\s+/);

                  for (const word of words) {
                    const similarity = getStringSimilarity(word, searchText);

                    if (similarity <= Math.ceil(searchText.length / 3)) {
                      showItem = true;
                      break;
                    }

                    if (word.toLowerCase().startsWith(searchText.toLowerCase())) {
                      showItem = true;
                      break;
                    }
                  }
                }
              }

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

              // Add null check for pageItemLimit
              if (!pageItemLimit || !pageItemLimit.value) {
                console.warn('pageItemLimit not found in registered parameters, skipping pagination');
                return;
              }

              const pages = Math.ceil(itemsArray.length / pageItemLimit.value);

              const currentPage = parseInt(value) || 1;
              const startIndex = (currentPage - 1) * pageItemLimit.value;
              const endIndex = startIndex + pageItemLimit.value;

              itemsArray.forEach(item => {
                  item.style.display = 'none';
              });

              for (let i = startIndex; i < endIndex && i < itemsArray.length; i++) {
                  itemsArray[i].style.display = '';
              }

              const totalPages = registeredParameters.find(item => item.parameter === "totalPages");

              // Add null check for totalPages
              if (totalPages) {
                totalPages.value = pages;

                triggerCustomEvent(document, "filter:castUpdate", {
                  id: totalPages.id,
                  parameter: totalPages.parameter,
                  value: totalPages.value
                });
              }
          }
          break;

        default:
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
      console.log(event);

      if (isClearing) {
        console.log('Ignoring filter update during clearing process');
        return;
      }

      const useLabel = event.data.useLabel || false;
      const forceClear = event.data.forceClear || false;
      updateFilter(event.data.parameter, event.data.value, useLabel, event.data.label ?? null, forceClear);
    });

    document.addEventListener('filter:clear', function(event) {
      clearFilters();
    });

    document.addEventListener('filter:requestCount', function(event) {
      if (event.data && event.data.callback) {
        const counts = getVisibleItemsCount();
        event.data.callback(counts);
      }
    });

    document.addEventListener('filter:requestActiveFilters', function(event) {
      if (event.data && event.data.callback) {
        const activeFilters = getActiveFiltersFromURL();
        event.data.callback(activeFilters);
      }
    });
  }

  function _registerComponent(event) {
    if (!event || !event.data) {
      return;
    }

    let filterData = event.data;

    // Check if this component should be persistent
    const shouldPersist = filterData.persist || false;

    registeredParameters.push({
      id: filterData.id,
      parameter: filterData.parameter,
      value: filterData.value !== undefined ? filterData.value : filterData.values,
      label: filterData.label,
      persist: shouldPersist
    });

    console.log('Registered component:', {
      id: filterData.id,
      parameter: filterData.parameter,
      persist: shouldPersist
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
    document.removeEventListener('filter:updated', updateFilter);
    document.removeEventListener('filter:clear', null);
    document.removeEventListener('filter:requestCount', null);
    document.removeEventListener('filter:requestActiveFilters', null);

    if (noResultsElement && noResultsElement.parentNode) {
      noResultsElement.parentNode.removeChild(noResultsElement);
    }
  };

  this.init = function() {
    _init();
  };
};

export default dynamicFilter;