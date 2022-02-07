import { queryStringHandler } from '@area17/a17-helpers';

const printPage = function(container) {

  function _handleClicks(event) {
    event.preventDefault();
    var printWindow = window.open(queryStringHandler.updateParameter(window.location.href, 'print', 'true'), 'AIC_printWindow');
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

export default printPage;
