import { purgeProperties, queryStringHandler, triggerCustomEvent } from '@area17/a17-helpers';
import { youtubePercentTracking } from '../functions';

const triggerMediaInline = function(container) {
  let iframe;
  let src;
  let embedType;
  let embedSrcType;

  function _handleClicks(event) {
    event.preventDefault();
    event.stopPropagation();
    container.removeEventListener('click', _handleClicks);
    container.removeEventListener('keyup', _handleKeyUp);
    src = queryStringHandler.updateParameter(src, 'autoplay', '1');
    src = queryStringHandler.updateParameter(src, 'auto_play', '1');
    iframe.src = src;
    container.classList.add('s-inline-media-activated');
  }

  function _handleKeyUp(event) {
    if (event.keyCode == 13) {
      _handleClicks(event);
    }
  }

  function _init() {
    iframe = container.querySelector('iframe');

    if (!iframe) {
      return;
    }

    src = iframe.getAttribute('data-embed-src');
    embedSrcType = 'data-embed-src';

    if (src === '' || !src) {
      src = iframe.getAttribute('data-src');
      embedSrcType = 'data-src';
    }

    if (src === '' || !src) {
      src = iframe.getAttribute('src');
      embedSrcType = 'src';
    }

    if (src === '' || !src) {
      return;
    }

    if (src.indexOf('youtube.com') > -1) {
      src = queryStringHandler.updateParameter(src, 'enablejsapi', '1');
      src = queryStringHandler.updateParameter(src, 'origin', window.location.origin);

      if (embedSrcType === 'data-src') {
        iframe.setAttribute('data-src', src);
      }

      if (embedSrcType === 'src') {
        iframe.src = src;
        youtubePercentTracking(iframe);
      } else {
        iframe.addEventListener('load',function(){
          youtubePercentTracking(iframe);
        }, false);
      }
    }

    if (embedSrcType !== 'data-src') {
      container.addEventListener('click', _handleClicks, false);
      container.addEventListener('keyup', _handleKeyUp, false);
    } else {
      container.classList.add('s-inline-media-activated');
    }
  }

  this.destroy = function() {
    // remove specific event handlers
    container.removeEventListener('click', _handleClicks);
    container.removeEventListener('keyup', _handleKeyUp);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default triggerMediaInline;

