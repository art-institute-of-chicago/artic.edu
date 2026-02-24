import { purgeProperties } from '@area17/a17-helpers';
import { queryStringHandler } from '@area17/a17-helpers';
import { youtubeEmbed } from '../../functions/core';

const triggerMediaInline = function(container) {
  let iframe;
  let src;
  let embedSrcType;
  let platform = container.dataset.platform;

  function _handleClicks(event) {
    event.preventDefault();
    event.stopPropagation();
    container.removeEventListener('click', _handleClicks);
    container.removeEventListener('keyup', _handleKeyUp);
    activateMedia();
  }

  function _handleKeyUp(event) {
    if (event.keyCode === 13) {
      _handleClicks(event);
    }
  }

  function activateMedia() {
    src = queryStringHandler.updateParameter(src, 'autoplay', (platform == 'vimeo' ? 'true' : '1'));
    src = queryStringHandler.updateParameter(src, 'auto_play', (platform == 'vimeo' ? 'true' : '1'));
    iframe.src = src;
    container.classList.add('s-inline-media-activated');
  }

  function _init() {
    iframe = container.querySelector('iframe');

    console.log('triggerMediaInline', iframe);
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

      if (embedSrcType === 'data-src') {
        iframe.setAttribute('data-src', src);
      }

      if (embedSrcType === 'src') {
        console.log('triggerMediaInline', 'starting youtubeEmbed');
        iframe.src = src;
        youtubeEmbed(iframe);
      } else {
        iframe.addEventListener('load',function(){
          youtubeEmbed(iframe);
        }, false);
      }
    }

    if (embedSrcType !== 'data-src') {
      container.addEventListener('click', _handleClicks, false);
      container.addEventListener('keyup', _handleKeyUp, false);
    } else {
      activateMedia();
    }

    container.addEventListener('youtube:playing', () => activateMedia());
  }

  this.destroy = function() {
    // Remove specific event handlers
    container.removeEventListener('click', _handleClicks);
    container.removeEventListener('keyup', _handleKeyUp);
    container.removeEventListener('youtube:playing', () => activateMedia());
    purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default triggerMediaInline;
