import { purgeProperties, triggerCustomEvent, ajaxRequest } from '@area17/a17-helpers';

const addHistory = function(container) {

  const addUrl = container.getAttribute('data-add-url');

  function _getUrl() {
    let token = document.querySelector('meta[name="csrf-token"]');
    if (token) {
      token = token.getAttribute('content');
    } else {
      token = '';
    }

    ajaxRequest({
      url: addUrl,
      type: 'GET',
      requestHeaders: [
        {
          header: 'X-CSRF-Token',
          value: token
        }
      ],
      onSuccess: function(data){
      },
      onError: function(data){
        console.log(data);
      }
    });
  }

  function _init() {
    if (addUrl) {
      _getUrl();
    }
  }

  this.destroy = function() {
    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default addHistory;
