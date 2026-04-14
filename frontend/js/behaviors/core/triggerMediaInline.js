import { purgeProperties, queryStringHandler } from '@area17/a17-helpers';
import youtubeEmbed, { controlYouTubePlayer } from '../../functions/core/youtubeEmbed';

const triggerMediaInline = function(container) {
  let iframe;
  let src;
  let embedSrcType;
  let isYoutube = false;
  let pendingPlay = false;
  let _youtubeLoadHandler = null;

  function _youtubePlayAndActivate() {
    const player = AIC.YouTubeembeds[iframe.id];
    controlYouTubePlayer(player, { 'playVideo': true });
    activateMedia();
  }

  function _onYoutubeReady() {
    iframe.removeEventListener('youtube:ready', _onYoutubeReady);
    if (pendingPlay) {
      _youtubePlayAndActivate();
    }
  }

  function _handleClicks(event) {
    event.preventDefault();
    event.stopPropagation();
    activateMedia();
    if (isYoutube === true) {
      if (AIC.YouTubeembeds[iframe.id]) {
        _youtubePlayAndActivate();
      } else {
        pendingPlay = true;
        // activateMedia() has reloaded the iframe fresh with autoplay=1.
        // Remove the load listener first to prevent a second youtubeEmbed()
        // call when the reloaded iframe fires its load event.
        if (_youtubeLoadHandler) {
          iframe.removeEventListener('load', _youtubeLoadHandler, false);
          _youtubeLoadHandler = null;
        }
        youtubeEmbed(iframe);
      }
    }
    container.removeEventListener('click', _handleClicks);
    container.removeEventListener('keyup', _handleKeyUp);
  }

  function _handleKeyUp(event) {
    if (event.keyCode === 13) {
      _handleClicks(event);
    }
  }

  function activateMedia() {
    // If the YouTube player hasn't connected yet, reload the iframe with autoplay
    // so the fresh handshake fires while the API is already listening. This is
    // required in Chrome/Safari, which don't re-establish the connection after
    // the iframe's initial handshake is missed (when the API loaded too late).
    if (isYoutube && !AIC.YouTubeembeds[iframe.id]) {
      src = queryStringHandler.updateParameter(src, 'autoplay', '1');
      iframe.src = src;
    }
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
      isYoutube = true;
      iframe.addEventListener('youtube:ready', _onYoutubeReady);

      if (embedSrcType === 'data-src') {
        iframe.setAttribute('data-src', src);
      }

      if (embedSrcType === 'src') {
        iframe.src = src;
        youtubeEmbed(iframe);
      } else {
        _youtubeLoadHandler = () => youtubeEmbed(iframe);
        iframe.addEventListener('load', _youtubeLoadHandler, false);
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
    iframe.removeEventListener('youtube:ready', _onYoutubeReady);
    iframe.removeEventListener('youtube:playing', activateMedia);
    if (_youtubeLoadHandler) {
      iframe.removeEventListener('load', _youtubeLoadHandler, false);
    }
    purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default triggerMediaInline;
