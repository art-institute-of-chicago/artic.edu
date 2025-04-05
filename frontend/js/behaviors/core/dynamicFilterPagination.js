import { triggerCustomEvent } from "@area17/a17-helpers"
import generateComponentId from "../../functions/core/generateComponentId";
import _ from "lodash";

const dynamicFilterPagination = function(container) {
  const id = Array.from({ length: 3 }, () => generateComponentId());
  const parameters = ['pageItemLimit', 'page', 'totalPages'];
  const pageButtons = container.querySelectorAll('[data-button-paginate]');
  const pageItemLimit = container.getAttribute('data-pagination-limit');
  let totalPages = null;
  let pageNumber = 1;

  function _filterRegister() {
    // Because this component needs to parse items and have a limit
    // we need to register it thrice with it's params
    // One for the page limit
    triggerCustomEvent(document, "filter:register", {
      id: id[0],
      parameter: parameters[0],
      value: parseInt(pageItemLimit),
    });

    // One for the component and it's button value
    triggerCustomEvent(document, "filter:register", {
      id: id[1],
      parameter: parameters[1],
      value: pageNumber || 1,
    });

    // One for the total pages
    triggerCustomEvent(document, "filter:register", {
      id: id[2],
      parameter: parameters[2],
      value: totalPages,
    });
  }

  function _clicks(e) {
    e.preventDefault();
    const target = e.target.closest('[data-button-paginate]');
    if (target) {
      const clickedPage = target.getAttribute('data-button-paginate');
      pageNumber = parseInt(clickedPage);

      triggerCustomEvent(document, "filter:updated", {
        id: id[1],
        parameter: parameters[1],
        value: pageNumber,
      });
    }
    window.requestAnimationFrame(() => {
        window.scrollTo({
            top: (document.querySelector('[data-filter-target]').offsetTop - 400),
            behavior: 'smooth'
        });
    });

  }

  function _updateFilter(event) {
    if (!event.data) return;

    // Setting page number from update
    if ((event.data.id === id[1]) && (event.data.parameter === parameters[1])) {
      const matchingItem = Array.from(pageButtons).find(item =>
        item.getAttribute('data-button-paginate') === String(event.data.value)
      );

      if (matchingItem) {
        matchingItem.classList.add('s-active');
        pageNumber = parseInt(event.data.value) || 1;

        // Update the current page text
        const currentPageText = container.querySelector('.m-paginator__current-page');
        if (currentPageText) {
          currentPageText.textContent = `Page ${pageNumber}`;
        }

        // Update Next/Previous buttons
        const prevNextContainer = container.querySelector('.m-paginator__prev-next');
        if (prevNextContainer) {
          const nextLi = prevNextContainer.querySelector('li:first-child');
          const prevLi = prevNextContainer.querySelector('li:last-child');

          if (nextLi && prevLi) {
            // Previous button - disabled if on page 1
            if (pageNumber <= 1) {
              prevLi.innerHTML = `<span class="f-buttons">
                <span>Previous</span>
                <svg aria-hidden="true" class="icon--arrow"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow"></use></svg>
              </span>`;
            } else {
              prevLi.innerHTML = `<a class="f-buttons" data-button-paginate="${pageNumber - 1}">
                <span>Previous</span>
                <svg aria-hidden="true" class="icon--arrow"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow"></use></svg>
              </a>`;
            }

            // Next button - disabled if on last page
            if (totalPages !== null && pageNumber >= totalPages) {
              nextLi.innerHTML = `<span class="f-buttons">
                <span>Next</span>
                <svg aria-hidden="true" class="icon--arrow"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow"></use></svg>
              </span>`;
            } else {
              nextLi.innerHTML = `<a class="f-buttons" data-button-paginate="${pageNumber + 1}">
                <span>Next</span>
                <svg aria-hidden="true" class="icon--arrow"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow"></use></svg>
              </a>`;
            }
          }
        }
      }
    }

    // Setting total pages from update
    if ((event.data.id === id[2]) && (event.data.parameter === parameters[2])) {

      // Handle different data types for value
      let totalPagesValue = event.data.value;

      // If it's an object, try to extract a numeric value
      if (typeof totalPagesValue === 'object' && totalPagesValue !== null) {
        // Try to convert to string and then parse
        totalPagesValue = String(totalPagesValue);
      }

      if (totalPagesValue !== null && totalPagesValue !== undefined) {
        totalPages = parseInt(totalPagesValue);

        // Get the container for the page buttons
        const pagesContainer = container.querySelector('.m-paginator__pages');
        if (pagesContainer) {
          // Clear existing buttons
          pagesContainer.innerHTML = '';

          // Generate pagination buttons
          const MAX_VISIBLE_PAGES = 7;
          let pagesToShow = [];

          if (totalPages == 0) {
            container.style.display = 'none';
          } else {
            container.style.display = '';
          }

          if (totalPages <= MAX_VISIBLE_PAGES) {
            // If we have 7 or fewer pages, show all of them
            for (let i = 1; i <= totalPages; i++) {
              pagesToShow.push(i);
            }
          } else {
            // Always include the first page
            pagesToShow.push(1);

            // Determine which pages to show around current page
            if (pageNumber > 3) {
              pagesToShow.push('...');
            }

            // Show pages around current page
            let startPage = Math.max(2, pageNumber - 1);
            let endPage = Math.min(totalPages - 1, pageNumber + 1);

            // Adjust range when current page is near start or end
            if (pageNumber <= 3) {
              endPage = Math.min(5, totalPages - 1);
            }
            if (pageNumber >= totalPages - 2) {
              startPage = Math.max(2, totalPages - 4);
            }

            for (let i = startPage; i <= endPage; i++) {
              pagesToShow.push(i);
            }

            // Add ellipsis if needed
            if (pageNumber < totalPages - 2) {
              pagesToShow.push('...');
            }

            // Always include last page
            pagesToShow.push(totalPages);
          }

          // Create and append buttons
          pagesToShow.forEach(page => {
            const li = document.createElement('li');

            if (page === '...') {
              // Add ellipsis
              li.innerHTML = '<span class="f-buttons">&hellip;</span>';
            } else {
              // Add page button
              const isActive = page === pageNumber ? 's-active' : '';
              li.className = isActive;
              li.innerHTML = `<a class="f-buttons" data-button-paginate="${page}">${page}</a>`;
            }

            pagesContainer.appendChild(li);
          });

          // Update Next/Previous buttons based on new total pages
          const prevNextContainer = container.querySelector('.m-paginator__prev-next');
          if (prevNextContainer) {
            const nextLi = prevNextContainer.querySelector('li:first-child');
            const prevLi = prevNextContainer.querySelector('li:last-child');

            if (nextLi && prevLi) {
              // Previous button - disabled if on page 1
              if (pageNumber <= 1) {
                prevLi.innerHTML = `<span class="f-buttons">
                  <span>Previous</span>
                  <svg aria-hidden="true" class="icon--arrow"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow"></use></svg>
                </span>`;
              } else {
                prevLi.innerHTML = `<a class="f-buttons" data-button-paginate="${pageNumber - 1}">
                  <span>Previous</span>
                  <svg aria-hidden="true" class="icon--arrow"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow"></use></svg>
                </a>`;
              }

              // Next button - disabled if on last page
              if (pageNumber >= totalPages) {
                nextLi.innerHTML = `<span class="f-buttons">
                  <span>Next</span>
                  <svg aria-hidden="true" class="icon--arrow"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow"></use></svg>
                </span>`;
              } else {
                nextLi.innerHTML = `<a class="f-buttons" data-button-paginate="${pageNumber + 1}">
                  <span>Next</span>
                  <svg aria-hidden="true" class="icon--arrow"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow"></use></svg>
                </a>`;
              }
            }
          }
        }
      }
    }
  }

  function _init() {
    _filterRegister();
    container.addEventListener('click', _clicks);
    document.addEventListener('filter:castUpdate', _updateFilter);
    document.addEventListener('filter:updated', _updateFilter);
    document.addEventListener('filter:init', _filterRegister);
  }

  this.destroy = function() {
    container.removeEventListener('click', _clicks);
    document.removeEventListener('filter:init', _filterRegister);
    document.removeEventListener('filter:castUpdate', _updateFilter);
    document.removeEventListener('filter:updated', _updateFilter);
  };

  this.init = function() {
    _init();
  }
}

export default dynamicFilterPagination;