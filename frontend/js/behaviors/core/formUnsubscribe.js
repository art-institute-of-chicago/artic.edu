import { forEach } from '@area17/a17-helpers';

const formUnsubscribe = function(container) {

  function _toggle(event) {
    event.preventDefault();
    event.stopPropagation();

    let checkbox = container.querySelector('input[type=checkbox][name^="unsubscribe"]');
    let targets;

    switch (checkbox.id) {
      case 'unsubscribeFromAll':
        targets = document.querySelectorAll(
          'input[type=checkbox]' +
          '[name^="subscriptions[]"]' +
          ':not([id="subscriptions-OptEnews"])'
        );
        break;
    }

    checkbox.checked = !checkbox.checked;

    forEach(targets, function(index, el) {
      if (checkbox.checked) {
        el.setAttribute('disabled', 'true');
        el.removeAttribute('checked');
        el.checked = false;
      } else {
        el.removeAttribute('disabled');
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
