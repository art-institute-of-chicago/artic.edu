import { triggerCustomEvent } from '@area17/a17-helpers';
import generateComponentId from '../../functions/core/generateComponentId';

const dynamicFilterDropdown = function(container) {
  const id = generateComponentId();
  container.setAttribute("data-filter-id", id);

  let active = false;
  let initialTitle = '';
  let initialized = false;

  const filterType = container.getAttribute('data-filter-behavior');
  const filterLabel = container.getAttribute('data-filter-label');
  const filterPersist = container.getAttribute('data-filter-persist') ?? null;
  const isPersistent = filterPersist !== null;

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

    if (!isActive && container.contains(event.target)) {
      _open();
    }

    if (isActive && dropdownList && dropdownList.contains(event.target)) {
      let selectedItem = event.target;
      let selectedValue = selectedItem.closest('[data-button-value]').getAttribute('data-button-value');
      let value = null;
      let wasToggedOff = false;

      dropdownItems.forEach(item => {
        if ((item.getAttribute('data-button-value') === selectedValue) && selectedItem.closest('[data-button-value]').classList.contains('s-active')) {
          item.classList.remove('s-active');
          wasToggedOff = true;
        } else if (item.getAttribute('data-button-value') === selectedValue) {
          item.classList.add('s-active');
          value = selectedValue;
        } else {
          item.classList.remove('s-active');
        }
      });

      if (value) {
        trigger.classList.add('s-active');
        updateButtonText(selectedItem.innerText);

        triggerCustomEvent(document, 'filter:updated', {
          id: id,
          parameter: filterType,
          value: value,
          label: filterLabel,
          useLabel: !!filterLabel,
          persist: isPersistent
        });
      } else {
        trigger.classList.remove('s-active');
        updateButtonText(initialTitle);

        triggerCustomEvent(document, 'filter:updated', {
          id: id,
          parameter: filterType,
          value: null,
          label: filterLabel,
          useLabel: !!filterLabel,
          persist: isPersistent,
          forceClear: wasToggedOff
        });
      }

      _close();
    }

    if (isActive && !dropdownList.contains(event.target)) {
      _close();
    }
  }

  function updateButtonText(newText) {
    if (!button) return;

    if (button.childNodes.length > 0 && button.childNodes[0].nodeType === Node.TEXT_NODE) {
      button.childNodes[0].textContent = newText;
    } else {
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
    triggerCustomEvent(document, 'filter:register', {
      id: id,
      parameter: filterType,
      values: Array.from(dropdownItems).map(item =>
        item.getAttribute('data-button-value')
      ),
      label: filterLabel,
      persist: isPersistent
    });
  }

  function resetFilter(event) {
    if (event.data.parameter === filterType && event.data.id !== id) {
      if (!isPersistent) {
        updateButtonText(initialTitle);
        trigger.classList.remove('s-active');
        dropdownItems.forEach(item => {
          item.classList.remove('s-active');
        });
      }
    }
  }

  function clearPersistentFilter() {
    if (isPersistent) {
      dropdownItems.forEach(item => {
        item.classList.remove('s-active');
      });

      trigger.classList.remove('s-active');
      updateButtonText(initialTitle);

      triggerCustomEvent(document, 'filter:updated', {
        id: id,
        parameter: filterType,
        value: null,
        label: filterLabel,
        useLabel: !!filterLabel,
        persist: isPersistent,
        forceClear: true
      });
    }
  }

  function _init() {
    _setup();
    _filterRegister();

    document.addEventListener('filter:init', _filterRegister);
    document.addEventListener('filter:updated', resetFilter);

    document.addEventListener('filter:clearPersistent', function(event) {
      if (event.data && event.data.id === id) {
        clearPersistentFilter();
      }
    });

    document.addEventListener('filter:castUpdate', function(event) {
      if (event.data.id !== id) {
        return;
      }

      const matchingItem = Array.from(dropdownItems).find(item =>
        item.getAttribute('data-button-value') === event.data.value
      );

      if (matchingItem) {
        trigger.classList.add('s-active');
        dropdownItems.forEach(item => {
          if (item === matchingItem) {
            item.classList.add('s-active');
          } else {
            item.classList.remove('s-active');
          }
        });
        updateButtonText(matchingItem.innerText);
      } else if (event.data.value === null || event.data.value === '') {
        if (!isPersistent || event.data.forceClear) {
          dropdownItems.forEach(item => {
            item.classList.remove('s-active');
          });
          trigger.classList.remove('s-active');
          updateButtonText(initialTitle);
        }
      }
    });

    document.addEventListener('filter:cleared', function(event) {
      // Reset dropdown to default state when clearing happens
      // Do this silently without triggering updates
      dropdownItems.forEach(item => {
        item.classList.remove('s-active');
      });
      trigger.classList.remove('s-active');
      updateButtonText(initialTitle);
    });

    initialized = true;
  }

  this.destroy = function() {
    container.removeEventListener('click', _clicks);
    document.removeEventListener('filter:init', _filterRegister);
    document.removeEventListener('filter:updated', resetFilter);
    document.removeEventListener('filter:castUpdate', null);
    document.removeEventListener('filter:clearPersistent', null);
    document.removeEventListener('filter:cleared', null);
  };

  this.init = function() {
    if (!initialized) {
      _init();
    }
  };

  this.clearPersistent = function() {
    clearPersistentFilter();
  };

  this.isPersistent = function() {
    return isPersistent;
  };

  this.getActiveValues = function() {
    const activeItems = Array.from(dropdownItems).filter(item => item.classList.contains('s-active'));
    return activeItems.map(item => item.getAttribute('data-button-value'));
  };
};

export default dynamicFilterDropdown;