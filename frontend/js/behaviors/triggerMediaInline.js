import { purgeProperties, queryStringHandler } from '@area17/a17-helpers';

const triggerMediaInline = function(container) {

  function _handleClicks(event) {
    event.preventDefault();
    event.stopPropagation();
    let iframe = container.querySelector('iframe[data-embed-src]');
    if (iframe) {
      var src = iframe.getAttribute('data-embed-src');
      src = queryStringHandler.updateParameter(src, 'autoplay', '1');
      src = queryStringHandler.updateParameter(src, 'auto_play', '1');
      iframe.src = src;
    }
  }

  function _init() {
    container.addEventListener('click', _handleClicks, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    container.removeEventListener('click', _handleClicks);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default triggerMediaInline;

