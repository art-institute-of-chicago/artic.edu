import { triggerCustomEvent, queryStringHandler } from '@area17/a17-helpers';

const mobileSearch = function(container) {

  const textInput = container.querySelector('input[type="search"]');
  const form = container.querySelector('form');

  function _fixedEncodeURIComponent(str) {
    return encodeURIComponent(str).replace(/[!'()*]/g, function(c) {
      return '%' + c.charCodeAt(0).toString(16);
    });
  }

  // Handle form submit
  function _handleSubmit(event){
    event.preventDefault();
    let terms = _fixedEncodeURIComponent(textInput.value);
    if (terms.length > 0) {
      triggerCustomEvent(document, 'navMobile:close');
      triggerCustomEvent(document, 'ajax:getPage', {
        url: queryStringHandler.updateParameter(form.action, 'q', terms),
      });
    }
  }


  function _init() {
    form.addEventListener('submit', _handleSubmit, false);
  }

  this.destroy = function() {
    form.removeEventListener('submit', _handleSubmit);
    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default mobileSearch;
