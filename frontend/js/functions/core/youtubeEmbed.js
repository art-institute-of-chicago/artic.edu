import { triggerCustomEvent } from '@area17/a17-helpers';

const youtubeEmbed = async function(iframe) {
  if (!(iframe instanceof Element)) {
    iframe = document.getElementById(iframe);
  }

  const playedChecks = {
    25: false,
    50: false,
    75: false,
  };

  let youtubePlayerTimer;

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
    youtubePlayerTimer = setInterval(_checkPlayedPercent, 250, player);
  }

  function onPlayerPaused() {
    triggerCustomEvent(document, 'gtm:push', {
      'event': 'paused',
      'eventCategory': 'video-engagement',
    });
  }

  function _checkPlayedPercent(player) {
    const playedPercent = Math.round(player.getCurrentTime() / player.getDuration() * 100);
    for (const playedCheck in playedChecks) {
      if (playedPercent >= playedCheck && !playedChecks[playedCheck]) {
        playedChecks[playedCheck] = true;
        triggerCustomEvent(document, 'gtm:push', {
          'event': `${playedCheck}%`,
          'eventCategory': 'video-engagement',
        });
      }
    }
  }

  function _onReady(event) {
    const player = event.target;
    iframe = player.getIframe();
    A17.YouTubeembeds[iframe.id] = player;
    triggerCustomEvent(iframe, 'youtube:ready', {id: iframe.id, player: player});
  }

  function _onStateChange(event) {
    try {
      clearInterval(youtubePlayerTimer);
    } catch (err) {
      // noop
    }
    iframe = event.target.getIframe();
    switch (event.data) {
      case YT.PlayerState.ENDED:
        triggerCustomEvent(iframe, 'youtube:ended', {id: iframe.id});
        onPlayerEnded();
        break;
      case YT.PlayerState.PLAYING:
        triggerCustomEvent(iframe, 'youtube:playing', {id: iframe.id});
        onPlayerPlaying(event.target);
        break;
      case YT.PlayerState.PAUSED:
        triggerCustomEvent(iframe, 'youtube:paused', {id: iframe.id});
        onPlayerPaused();
        break;
      case YT.PlayerState.BUFFERING:
        triggerCustomEvent(iframe, 'youtube:buffering', {id: iframe.id});
        break;
      case YT.PlayerState.CUED:
        triggerCustomEvent(iframe, 'youtube:cued', {id: iframe.id});
        break;
      default:
        // noop
        break;
    }
  }

  function _initYoutubePlayer(iframeId) {
    if (A17.YouTubeonYouTubeIframeAPIReady) {
      if (!(iframeId in A17.YouTubeembeds)) {
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
      setTimeout(() => _initYoutubePlayer(iframeId), 10);
    }
  };

  if (!document.getElementById('youtubeapijs')) {
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

function controlYouTubePlayer(player, commands) {
  for (const command in commands) {
    switch (command) {
      case 'loadVideoById':
        player.loadVideoById(commands[command]);
        break;
      case 'pauseVideo':
        player.pauseVideo();
        break;
      case 'playVideo':
        player.playVideo();
        break;
      case 'seekTo':
        player.seekTo(commands[command], true)
        break;
      case 'stopVideo':
        player.stopVideo();
        break;
      case 'destroy':
        player.destroy();
        break;
      default:
        // noop
        break;
    }
  }
}

function unsetEmbed(iframe) {
  controlYouTubePlayer(A17.YouTubeembeds[iframe.id], { 'destroy': true });
  delete A17.YouTubeembeds[iframe.id];
}

export { controlYouTubePlayer, unsetEmbed, youtubeEmbed as default };
