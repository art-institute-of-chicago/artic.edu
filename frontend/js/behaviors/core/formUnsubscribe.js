import { forEach } from '@area17/a17-helpers';

const formUnsubscribe = function(container) {
  let optMuseum = document.getElementById('subscriptions-OptMuseum');
  let optOthers = Array.from(document.querySelectorAll(
    'input[type=checkbox]' +
    '[name^="subscriptions[]"]' +
    ':not([id="subscriptions-OptMuseum"])'
  ));

  let unsubscribeFromMuseum = document.getElementById('unsubscribeFromMuseum');
  let unsubscribeFromAll = document.getElementById('unsubscribeFromAll');

  let checkbox = container.querySelector('input[type=checkbox][name^="unsubscribe"]');

  function _toggle(event) {
    event.preventDefault();
    event.stopPropagation();

    let targets = [];

    checkbox.checked = !checkbox.checked;

    if (checkbox.id == 'unsubscribeFromAll') {
      unsubscribeFromMuseum.checked = unsubscribeFromAll.checked;
    }

    if ((
      checkbox.id == 'unsubscribeFromMuseum'
    ) && (
      unsubscribeFromMuseum.checked
    )) {
      unsubscribeFromAll.checked = true;
    }

    if (unsubscribeFromAll.checked && (
      !unsubscribeFromMuseum.checked
    )) {
      unsubscribeFromAll.checked = false
    }

    if (unsubscribeFromMuseum.checked) {
      _disable(optOthers);
    } else {
      _enable(optOthers);
    }

    optMuseum.checked = !unsubscribeFromMuseum.checked;
  }

  function _disable(targets) {
    forEach(targets, function(index, el) {
      if (el.disabled !== true) {
        el.savedState = el.checked;
        el.setAttribute('disabled', 'true');
        el.removeAttribute('checked');
        el.checked = false;
      }
    });
  }

  function _enable(targets) {
    forEach(targets, function(index, el) {
      el.removeAttribute('disabled');
      if (el.hasOwnProperty('savedState')) {
        el.checked = el.savedState;
        delete el.savedState;
      }
    });
  }

  function _handleClicks(event) {
    _toggle(event);
  }

  function _init() {
    container.addEventListener('click', _handleClicks, false);
  }

  this.destroy = function() {
    // Remove specific event handlers
    container.removeEventListener('click', _handleClicks);

    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default formUnsubscribe;
