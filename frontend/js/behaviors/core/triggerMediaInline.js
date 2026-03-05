import { purgeProperties } from '@area17/a17-helpers';
import youtubeEmbed, { controlYouTubePlayer } from '../../functions/core/youtubeEmbed';

const triggerMediaInline = function(container) {
  let iframe;
  let src;
  let embedSrcType;

  function _handleClicks(event) {
    event.preventDefault();
    event.stopPropagation();
    container.removeEventListener('click', _handleClicks);
    container.removeEventListener('keyup', _handleKeyUp);
    const player = A17.YouTubeembeds[iframe.id];
    controlYouTubePlayer(player, { 'playVideo': true });
    activateMedia();
  }

  function _handleKeyUp(event) {
    if (event.keyCode === 13) {
      _handleClicks(event);
    }
  }

  function activateMedia() {
    container.classList.add('s-inline-media-activated');
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

      if (embedSrcType === 'data-src') {
        iframe.setAttribute('data-src', src);
      }

      if (embedSrcType === 'src') {
        iframe.src = src;
        youtubeEmbed(iframe);
      } else {
        iframe.addEventListener('load', () => youtubeEmbed(iframe), false);
      }
    }

    if (embedSrcType !== 'data-src') {
      container.addEventListener('click', _handleClicks, false);
      container.addEventListener('keyup', _handleKeyUp, false);
    } else {
      activateMedia();
    }

    iframe.addEventListener('youtube:playing', activateMedia);
  }

  this.destroy = function() {
    // Remove specific event handlers
    container.removeEventListener('click', _handleClicks);
    container.removeEventListener('keyup', _handleKeyUp);
    iframe.removeEventListener('youtube:playing', activateMedia);
    purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default triggerMediaInline;
