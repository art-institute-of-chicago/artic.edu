import { triggerCustomEvent, objectifyForm } from '@area17/a17-helpers';

const reportSearchToGoogleTagManager = function(container) {

  function _init() {
    let formData = objectifyForm(container);
    if (formData.search && formData.search !== '') {
      triggerCustomEvent(document, 'gtm:push', {
        'event': formData.search,
        'eventCategory': 'site-search',
      });
    }
  }

  this.destroy = function() {
    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default reportSearchToGoogleTagManager;
