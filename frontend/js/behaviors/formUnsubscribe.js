import { purgeProperties, forEach } from '@area17/a17-helpers';

const formUnsubscribe = function(container) {

  function _toggle(event) {
    event.preventDefault();
    event.stopPropagation();
    forEach(document.querySelectorAll('input[type=checkbox][name^="subscriptions[]"]:not([id="subscriptions-OptEnews"])'), function(index, el) {
      if (el.getAttribute('disabled') === 'true') {
        // Enable
        el.removeAttribute('disabled');
        container.querySelector('input[type=checkbox][name="unsubscribe"]').checked = false;
      } else {
        // Disable
        el.setAttribute('disabled', 'true');
        el.removeAttribute('checked');
        el.checked = false;
        container.querySelector('input[type=checkbox][name="unsubscribe"]').checked = true;
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
