import { triggerCustomEvent, queryStringHandler } from '@area17/a17-helpers';
import { googleTagManagerDataFromLink } from '../../functions/core';

const ajaxFormSubmit = function(container) {

  const textInput = container.querySelector('input[type="search"]') || container.querySelector('input[type="text"]');
  const form = container;

  function _fixedEncodeURIComponent(str) {
    return encodeURIComponent(str).replace(/[!'()*]/g, function(c) {
      return '%' + c.charCodeAt(0).toString(16);
    });
  }

  // Handle form submit
  function _handleSubmit(event){
    event.preventDefault();
    let terms = _fixedEncodeURIComponent(textInput.value);
    var ajaxScrollTarget = container.getAttribute('data-ajax-scroll-target');
    if (terms.length > 0) {
      triggerCustomEvent(document, 'ajax:getPage', {
        url: queryStringHandler.updateParameter(form.action, 'q', terms),
        type: 'page',
        ajaxScrollTarget: ajaxScrollTarget
      });
      // If the form has some google tag manager props, tell GTM
      let googleTagManagerObject = googleTagManagerDataFromLink(container);
      if (googleTagManagerObject) {
        triggerCustomEvent(document, 'gtm:push', googleTagManagerObject);
      }
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

export default ajaxFormSubmit;
