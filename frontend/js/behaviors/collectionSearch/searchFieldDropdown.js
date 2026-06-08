import { queryStringHandler } from '@area17/a17-helpers';

const searchFieldDropdown = function(container) {
    const triggerBtn = container.querySelector('.dropdown__trigger');
    const triggerText = container.querySelector('.dropdown__trigger button');
    const list = container.querySelector('.dropdown__list');
    const items = container.querySelectorAll('li[data-search-value]');

    function toggle(e) {
        e.preventDefault();
        e.stopPropagation();
        const isActive = container.classList.contains('s-active');
        // Close all other dropdowns
        document.dispatchEvent(new CustomEvent('searchFieldDropdown:close'));
        if (!isActive) {
            container.classList.add('s-active');
            triggerBtn.setAttribute('aria-expanded', 'true');
        } else {
            container.classList.remove('s-active');
            triggerBtn.setAttribute('aria-expanded', 'false');
        }
    }

    function close() {
        container.classList.remove('s-active');
        triggerBtn.setAttribute('aria-expanded', 'false');
    }

    function _handleClick(e) {
        e.preventDefault();
        e.stopPropagation();

        const link = e.currentTarget;
        const item = link.closest('li[data-search-value]');
        if (!item) return;

        const val = item.getAttribute('data-search-value');
        const label = link.textContent.trim();

        // Update trigger button label
        if (triggerText.childNodes.length > 0 && triggerText.childNodes[0].nodeType === Node.TEXT_NODE) {
            triggerText.childNodes[0].textContent = label;
        } else {
            triggerText.insertBefore(document.createTextNode(label), triggerText.firstChild);
        }

        // Set active state
        items.forEach(i => i.classList.remove('s-active'));
        item.classList.add('s-active');

        // Update forms
        const inputs = document.querySelectorAll('input[name="collection-search"]');
        inputs.forEach(input => {
            const searchForm = input.closest('form');
            if (searchForm) {
                let hiddenInput = searchForm.querySelector('input[name="search_field"]');
                if (val) {
                    if (!hiddenInput) {
                        hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'search_field';
                        searchForm.appendChild(hiddenInput);
                    }
                    hiddenInput.value = val;
                } else if (hiddenInput) {
                    // if the value is empty, we remove the hidden field
                    hiddenInput.remove();
                }

                // Update form action for autocomplete.js
                const qsObj = queryStringHandler.toObject(searchForm.action);
                if (val) {
                    qsObj['search_field'] = val;
                } else {
                    delete qsObj['search_field'];
                }
                const baseUrl = searchForm.action.split('?')[0];
                searchForm.action = baseUrl + queryStringHandler.fromObject(qsObj);
            }
        });

        // Close dropdown
        close();
    }

    function _init() {
        triggerBtn.addEventListener('click', toggle);
        items.forEach(item => {
            const link = item.querySelector('a');
            if (link) {
                link.addEventListener('click', _handleClick);
            }
        });
        document.addEventListener('searchFieldDropdown:close', close);
        document.addEventListener('click', (e) => {
            if (!container.contains(e.target)) {
                close();
            }
        });
    }

    this.init = function() {
        _init();
    };

    this.destroy = function() {
        // clean up listeners
        triggerBtn.removeEventListener('click', toggle);
        items.forEach(item => {
            const link = item.querySelector('a');
            if (link) {
                link.removeEventListener('click', _handleClick);
            }
        });
        document.removeEventListener('searchFieldDropdown:close', close);
    };
};

export default searchFieldDropdown;
