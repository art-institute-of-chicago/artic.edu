// dynamicFilterCheckbox.js
import { triggerCustomEvent } from '@area17/a17-helpers';
import generateComponentId from '../../functions/core/generateComponentId';

const dynamicFilterCheckbox = function(container) {
  const id = generateComponentId();
  container.setAttribute("data-filter-id", id);

  let initialized = false;

  const filterType = container.getAttribute('data-filter-behavior');
  const filterLabel = container.getAttribute('data-filter-label');
  const filterValue = container.getAttribute('data-filter-value');
  const filterPersist = container.getAttribute('data-filter-persist') ?? null;
  const isPersistent = filterPersist !== null;

  const checkboxValue = filterValue;
  let isChecked = container.classList.contains('s-checked');

  function _setup() {
    const clickHandler = function(event) {
      event.preventDefault();
      isChecked = !isChecked;
      _handleChange();
    };

    container.addEventListener('click', clickHandler);
  }

  function _handleChange() {
    const value = isChecked ? checkboxValue : null;

    if (isChecked) {
      container.classList.add('s-checked');
      container.classList.add('s-active');
    } else {
      container.classList.remove('s-checked');
      container.classList.remove('s-active');
    }

    triggerCustomEvent(document, 'filter:updated', {
      id: id,
      parameter: filterType,
      value: value,
      label: filterLabel,
      useLabel: !!filterLabel,
      persist: isPersistent,
      forceClear: !isChecked
    });
  }

  function resetFilter(event) {
    if (event.data.parameter === filterType && event.data.id !== id) {
      if (!isPersistent) {
        isChecked = false;
        container.classList.remove('s-checked');
        container.classList.remove('s-active');
      }
    }
  }

  function _filterRegister() {
    triggerCustomEvent(document, 'filter:register', {
      id: id,
      parameter: filterType,
      value: checkboxValue,
      label: filterLabel,
      persist: isPersistent
    });
  }

  function clearPersistentFilter() {
    if (isPersistent) {
      isChecked = false;
      container.classList.remove('s-checked');
      container.classList.remove('s-active');

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
    if (!filterType) {
      return;
    }

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

      if (event.data.value === checkboxValue) {
        isChecked = true;
        container.classList.add('s-checked');
        container.classList.add('s-active');
      } else if (event.data.value === null || event.data.value === '') {
        if (!isPersistent || event.data.forceClear) {
          isChecked = false;
          container.classList.remove('s-checked');
          container.classList.remove('s-active');
        }
      }
    });

    // ADD: Listen for clear events to reset checkbox
    document.addEventListener('filter:cleared', function(event) {
      // Reset checkbox to default state when clearing happens
      // Do this silently without triggering updates
      isChecked = false;
      container.classList.remove('s-checked');
      container.classList.remove('s-active');
    });

    initialized = true;
  }

  this.destroy = function() {
    container.removeEventListener('click', _handleChange);
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

  this.getActiveValue = function() {
    return isChecked ? checkboxValue : null;
  };

  this.isChecked = function() {
    return isChecked;
  };

  this.setChecked = function(checked) {
    if (isChecked !== checked) {
      isChecked = checked;
      _handleChange();
    }
  };
};

export default dynamicFilterCheckbox;