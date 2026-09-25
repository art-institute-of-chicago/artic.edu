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

        const searchFieldValue = item.getAttribute('data-search-value');
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
                let searchFieldInput = searchForm.querySelector('input[name="search_field"]');
                let semanticOnlyInput = searchForm.querySelector('input[name="semantic_only"]');

                if (searchFieldValue === 'semantic') {
                    // Remove search_field, set semantic_only
                    if (searchFieldInput) searchFieldInput.remove();
                    searchFieldInput = null;
                    if (!semanticOnlyInput) {
                        semanticOnlyInput = document.createElement('input');
                        semanticOnlyInput.type = 'hidden';
                        semanticOnlyInput.name = 'semantic_only';
                        searchForm.appendChild(semanticOnlyInput);
                    }
                    semanticOnlyInput.value = '1';
                } else {
                    // Remove semantic_only if present
                    if (semanticOnlyInput) {
                        semanticOnlyInput.remove();
                        semanticOnlyInput = null;
                    }

                    if (searchFieldValue) {
                        // update search_field
                        if (!searchFieldInput) {
                            searchFieldInput = document.createElement('input');
                            searchFieldInput.type = 'hidden';
                            searchFieldInput.name = 'search_field';
                            searchForm.appendChild(searchFieldInput);
                        }
                        searchFieldInput.value = searchFieldValue;
                    } else {
                        // if all fields remove search_field
                        if (searchFieldInput) searchFieldInput.remove();
                    }
                }

                // Update form action for autocomplete.js
                const qsObj = queryStringHandler.toObject(searchForm.action);
                delete qsObj['search_field'];
                delete qsObj['semantic_only'];
                if (searchFieldValue === 'semantic') {
                    qsObj['semantic_only'] = '1';
                } else if (searchFieldValue) {
                    qsObj['search_field'] = searchFieldValue;
                }
                const baseUrl = searchForm.action.split('?')[0];
                searchForm.action = baseUrl + queryStringHandler.fromObject(qsObj);
            }
        });

        // Close dropdown
        close();
    }

    function syncFromForm() {

        const searchForm = document.querySelector('form.m-search-bar');
        if (!searchForm) return;

        const searchFieldInput = searchForm.querySelector('input[name="search_field"]');
        const semanticOnlyInput = searchForm.querySelector('input[name="semantic_only"]');

        let activeValue = '';
        if (semanticOnlyInput && semanticOnlyInput.value) {
            activeValue = 'semantic';
        } else if (searchFieldInput && searchFieldInput.value) {
            activeValue = searchFieldInput.value;
        }

        // Update trigger text and active item to match
        items.forEach(item => {
            const itemValue = item.getAttribute('data-search-value');
            if (itemValue === activeValue) {
                item.classList.add('s-active');
                const link = item.querySelector('a');
                if (link && triggerText) {
                    const label = link.textContent.trim();
                    if (triggerText.childNodes.length > 0 && triggerText.childNodes[0].nodeType === Node.TEXT_NODE) {
                        triggerText.childNodes[0].textContent = label;
                    } else {
                        triggerText.insertBefore(document.createTextNode(label), triggerText.firstChild);
                    }
                }
            } else {
                item.classList.remove('s-active');
            }
        });
    }

    function _init() {
        syncFromForm();
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
