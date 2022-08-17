import { forEach } from '@area17/a17-helpers';

const emailSubscriptions = function(container) {

  function _handleSubmit(event){
    event.preventDefault();

    let checkboxes = container.querySelectorAll('input[type="checkbox"]');

    forEach(checkboxes, function(index, el) {
      el.removeAttribute('disabled');
    });

    container.submit();

    forEach(checkboxes, function(index, el) {
      el.setAttribute('disabled', true);
    });
  }

  function _init() {
    container.addEventListener('submit', _handleSubmit, false);
  }

  this.destroy = function() {
    // Remove specific event handlers
    container.removeEventListener('submit', _handleSubmit);

    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default emailSubscriptions;
