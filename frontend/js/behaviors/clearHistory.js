import { purgeProperties, triggerCustomEvent, ajaxRequest } from '@area17/a17-helpers';
import { displayNotification } from '../functions';

const clearHistory = function(container) {

  const clearUrl = container.href;

  function _clearHistory(event) {
    event.preventDefault();
    event.stopPropagation();

    let token = document.querySelector('meta[name="csrf-token"]');
    if (token) {
      token = token.getAttribute('content');
    } else {
      token = '';
    }

    triggerCustomEvent(document, 'loader:start');

    ajaxRequest({
      url: clearUrl,
      type: 'GET',
      requestHeaders: [
        {
          header: 'X-CSRF-Token',
          value: token
        }
      ],
      onSuccess: function(data) {
        let loaderState = 'complete';
        try {
          var clearTarget = document.querySelector('[data-user-artwork-history]');
          if (clearTarget) {
            while (clearTarget.firstChild) {
              clearTarget.removeChild(clearTarget.firstChild);
            }
          }
          displayNotification({
            icon: 'check',
            text: 'History cleared',
            type: 'quaternary'
          });
          triggerCustomEvent(document, 'page:updated');
        } catch(err) {
          loaderState = 'error';
          console.log(err);
        }
        triggerCustomEvent(document, 'loader:'+loaderState);
      },
      onError: function(data){
        triggerCustomEvent(document, 'loader:error');
        console.log(data);
      }
    });
  }

  function _init() {
    container.addEventListener('click', _clearHistory, false);
  }

  this.destroy = function() {
    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default clearHistory;
