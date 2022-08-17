import { forEach } from '@area17/a17-helpers';

const formUnsubscribe = function(container) {
  let optMuseum = document.getElementById('subscriptions-OptMuseum');
  let optShop = document.getElementById('subscriptions-OptShop');
  let optOthers = Array.from(document.querySelectorAll(
    'input[type=checkbox]' +
    '[name^="subscriptions[]"]' +
    ':not([id="subscriptions-OptMuseum"])' +
    ':not([id="subscriptions-OptShop"])'
  ));

  let unsubscribeFromMuseum = document.getElementById('unsubscribeFromMuseum');
  let unsubscribeFromShop = document.getElementById('unsubscribeFromShop');
  let unsubscribeFromAll = document.getElementById('unsubscribeFromAll');

  let checkbox = container.querySelector('input[type=checkbox][name^="unsubscribe"]');

  function _toggle(event) {
    event.preventDefault();
    event.stopPropagation();

    let targets = [];

    checkbox.checked = !checkbox.checked;

    if (checkbox.id == 'unsubscribeFromAll') {
      unsubscribeFromMuseum.checked = unsubscribeFromAll.checked;
      unsubscribeFromShop.checked = unsubscribeFromAll.checked;
    }

    if (unsubscribeFromAll.checked && (
      !unsubscribeFromMuseum.checked || !unsubscribeFromShop.checked
    )) {
      unsubscribeFromAll.checked = false
    }

    if (unsubscribeFromMuseum.checked) {
      _disable(optOthers);
    } else {
      _enable(optOthers);
    }

    if (unsubscribeFromShop.checked) {
      _disable([optShop]);
    } else {
      _enable([optShop]);
    }

    optMuseum.checked = !unsubscribeFromMuseum.checked;
  }

  function _disable(targets) {
    forEach(targets, function(index, el) {
      el.setAttribute('disabled', 'true');
      el.removeAttribute('checked');
      el.checked = false;
    });
  }

  function _enable(targets) {
    forEach(targets, function(index, el) {
      el.removeAttribute('disabled');
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
