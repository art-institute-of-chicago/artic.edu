import { triggerCustomEvent, ajaxRequest } from '@area17/a17-helpers';

const injectContent = function(container) {

  const injectUrl = container.getAttribute('data-injectContent-url');

  function _inject(content) {
    container.innerHTML = content;
    triggerCustomEvent(document, 'page:updated');
    if (window.picturefill) {
      window.picturefill();
    }
  }

  function _getUrl() {
    let token = document.querySelector('meta[name="csrf-token"]');
    if (token) {
      token = token.getAttribute('content');
    } else {
      token = '';
    }

    ajaxRequest({
      url: injectUrl,
      type: 'GET',
      requestHeaders: [
        {
          header: 'X-CSRF-Token',
          value: token
        }
      ],
      onSuccess: function(data){
        try {
          var parsed = JSON.parse(data);
          _inject(parsed.html);
        } catch (err) {
          console.log(err);
        }
      },
      onError: function(data){
        console.log(data);
      }
    });
  }

  function _init() {
    if (injectUrl) {
      _getUrl();
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

export default injectContent;
