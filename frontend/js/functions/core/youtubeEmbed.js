import { triggerCustomEvent } from '@area17/a17-helpers';

const activeEmbeds = {};
let apiLoadAttempted = false;

const youtubeEmbed = function(iframe) {
  if (!(iframe instanceof Element)) {
    iframe = document.getElementById(iframe);
  }
  if (!iframe) return;

  const playedChecks = {
    25: false,
    50: false,
    75: false,
  };

  let youtubePlayerTimer;
  let initRetries = 0;

  function onPlayerEnded() {
    triggerCustomEvent(document, 'gtm:push', {
      'event': '100%',
      'eventCategory': 'video-engagement',
    });
  }

  function onPlayerPlaying(player) {
    triggerCustomEvent(document, 'gtm:push', {
      'event': 'playing',
      'eventCategory': 'video-engagement',
    });
    clearInterval(youtubePlayerTimer);
    youtubePlayerTimer = setInterval(() => _checkPlayedPercent(player), 250);
  }

  function onPlayerPaused() {
    triggerCustomEvent(document, 'gtm:push', {
      'event': 'paused',
      'eventCategory': 'video-engagement',
    });
  }

  function _checkPlayedPercent(player) {
    const duration = player.getDuration();
    if (!duration) return;

    const playedPercent = Math.round((player.getCurrentTime() / duration) * 100);
    for (const playedCheck in playedChecks) {
      const checkValue = parseInt(playedCheck, 10);
      if (playedPercent >= checkValue && !playedChecks[playedCheck]) {
        playedChecks[playedCheck] = true;
        triggerCustomEvent(document, 'gtm:push', {
          'event': `${checkValue}%`,
          'eventCategory': 'video-engagement',
        });
      }
    }
  }

  function _onReady(event) {
    const player = event.target;
    let currentIframe;
    try {
      currentIframe = player.getIframe();
    } catch(e) {
      return;
    }
    if (currentIframe.id in activeEmbeds) return;
    activeEmbeds[currentIframe.id] = player;
    triggerCustomEvent(currentIframe, 'youtube:ready', {id: currentIframe.id, player: player});
  }

  function _onStateChange(event) {
    try {
      clearInterval(youtubePlayerTimer);
    } catch (err) {
      // noop
    }
    const currentIframe = event.target.getIframe();
    switch (event.data) {
      case YT.PlayerState.ENDED:
        triggerCustomEvent(currentIframe, 'youtube:ended', {id: currentIframe.id});
        onPlayerEnded();
        break;
      case YT.PlayerState.PLAYING:
        triggerCustomEvent(currentIframe, 'youtube:playing', {id: currentIframe.id});
        onPlayerPlaying(event.target);
        break;
      case YT.PlayerState.PAUSED:
        triggerCustomEvent(currentIframe, 'youtube:paused', {id: currentIframe.id});
        onPlayerPaused();
        break;
      case YT.PlayerState.BUFFERING:
        triggerCustomEvent(currentIframe, 'youtube:buffering', {id: currentIframe.id});
        break;
      case YT.PlayerState.CUED:
        triggerCustomEvent(currentIframe, 'youtube:cued', {id: currentIframe.id});
        break;
      default:
        // noop
        break;
    }
  }

  function _initYoutubePlayer(iframeId) {
    if (window.YT && window.YT.Player) {
      if (!(iframeId in activeEmbeds)) {
        new YT.Player(iframeId, {
          playerVars: {
            'autoplay': 1,
            'enablejsapi': 1,
            'origin': window.location.origin,
          },
          events: {
            'onReady': _onReady,
            'onStateChange': _onStateChange,
          },
        });
      }
    } else {
      initRetries++;
      if (initRetries < 50) {
        setTimeout(() => _initYoutubePlayer(iframeId), 100);
      }
    }
  }

  if (!apiLoadAttempted && !document.getElementById('youtubeapijs')) {
    apiLoadAttempted = true;
    const youtubeScript = document.createElement('script');
    youtubeScript.src = 'https://www.youtube.com/iframe_api';
    youtubeScript.id = 'youtubeapijs';
    const firstScript = document.getElementsByTagName('script')[0];
    firstScript.parentNode.insertBefore(youtubeScript, firstScript);
  }

  if (!iframe.id) {
    iframe.id = `youtube_${Math.random().toString(36).substring(2, 9)}`;
  }
  _initYoutubePlayer(iframe.id);
};

function controlYouTubePlayer(iframeRef, commands) {
  const iframeEl = iframeRef instanceof Element ? iframeRef : document.getElementById(iframeRef);
  if (!iframeEl || !activeEmbeds[iframeEl.id]) return;

  const player = activeEmbeds[iframeEl.id];

  for (const command in commands) {
    switch (command) {
      case 'loadVideoById':
        if (typeof player.loadVideoById === 'function') player.loadVideoById(commands[command]);
        break;
      case 'pauseVideo':
        if (typeof player.pauseVideo === 'function') player.pauseVideo();
        break;
      case 'playVideo':
        if (typeof player.playVideo === 'function') player.playVideo();
        break;
      case 'seekTo':
        if (typeof player.seekTo === 'function') player.seekTo(commands[command], true);
        break;
      case 'stopVideo':
        if (typeof player.stopVideo === 'function') player.stopVideo();
        break;
      case 'destroy':
        if (typeof player.destroy === 'function') player.destroy();
        break;
      default:
        // noop
        break;
    }
  }
}

function unsetEmbed(iframe) {
  const iframeEl = iframe instanceof Element ? iframe : document.getElementById(iframe);
  if (iframeEl && activeEmbeds[iframeEl.id]) {
    controlYouTubePlayer(iframeEl, { 'destroy': true });
    delete activeEmbeds[iframeEl.id];
  }
}

export { controlYouTubePlayer, unsetEmbed, youtubeEmbed as default };
