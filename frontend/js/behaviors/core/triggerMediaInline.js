import { purgeProperties, queryStringHandler } from '@area17/a17-helpers';
import { youtubeEmbed } from '../../functions/core';

const triggerMediaInline = function(container) {
  let iframe;
  let embedSrcType;
  let baseSrc;
  let activatedSrc;

  const platform = container.dataset.platform;

  function markActivated() {
    container.classList.add('s-inline-media-activated');
  }

  function getActivatedSrc() {
    if (activatedSrc) {
      return activatedSrc;
    }

    let nextSrc = queryStringHandler.updateParameter(baseSrc, 'autoplay', (platform === 'vimeo' ? 'true' : '1'));
    nextSrc = queryStringHandler.updateParameter(nextSrc, 'auto_play', (platform === 'vimeo' ? 'true' : '1'));

    activatedSrc = nextSrc;
    return activatedSrc;
  }

  function activateMedia() {
    const nextSrc = getActivatedSrc();

    if (iframe.src !== nextSrc) {
      iframe.src = nextSrc;
    }

    markActivated();
  }

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

  function _handleYoutubePlaying() {
    markActivated();
  }

  function _handleIframeLoad() {
    youtubeEmbed(iframe);
  }

  function resolveEmbedSource() {
    baseSrc = iframe.getAttribute('data-embed-src');
    embedSrcType = 'data-embed-src';

    if (!baseSrc) {
      baseSrc = iframe.getAttribute('data-src');
      embedSrcType = 'data-src';
    }

    if (!baseSrc) {
      baseSrc = iframe.getAttribute('src');
      embedSrcType = 'src';
    }

    return !!baseSrc;
  }

  function clearCachedYouTubePlayer() {
    if (!iframe || !iframe.id || !A17.YouTubeembeds) {
      return;
    }

    const cachedEntry = A17.YouTubeembeds[iframe.id];
    if (!cachedEntry) {
      return;
    }

    if (cachedEntry.iframe && cachedEntry.iframe !== iframe) {
      return;
    }

    const destroyPlayer = (player) => {
      if (player && typeof player.destroy === 'function') {
        player.destroy();
      }
    };

    if (cachedEntry && typeof cachedEntry.then === 'function') {
      cachedEntry.then(destroyPlayer);
    } else if (cachedEntry && cachedEntry.playerPromise && typeof cachedEntry.playerPromise.then === 'function') {
      cachedEntry.playerPromise.then(destroyPlayer);
    } else {
      destroyPlayer(cachedEntry.player || cachedEntry);
    }

    delete A17.YouTubeembeds[iframe.id];
  }

  function _init() {
    iframe = container.querySelector('iframe');

    console.log('triggerMediaInline', iframe)

    if (!iframe || !resolveEmbedSource()) {
      return;
    }

    const isYouTube = baseSrc.indexOf('youtube.com') > -1;

    if (isYouTube) {
      if (embedSrcType === 'src') {
        console.log('triggerMediaInline', 'starting youtubeEmbed');
        youtubeEmbed(iframe);
      } else {
        iframe.addEventListener('load', _handleIframeLoad, false);
      }

      iframe.addEventListener('youtube:playing', _handleYoutubePlaying, false);
    }

    if (embedSrcType !== 'data-src') {
      container.addEventListener('click', _handleClicks, false);
      container.addEventListener('keyup', _handleKeyUp, false);
    } else {
      activateMedia();
    }
  }

  this.destroy = function() {
    container.removeEventListener('click', _handleClicks);
    container.removeEventListener('keyup', _handleKeyUp);

    if (iframe) {
      iframe.removeEventListener('load', _handleIframeLoad);
      iframe.removeEventListener('youtube:playing', _handleYoutubePlaying);
    }

    clearCachedYouTubePlayer();
    purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default triggerMediaInline;
