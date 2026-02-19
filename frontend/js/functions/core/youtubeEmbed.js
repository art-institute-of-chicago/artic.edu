import { triggerCustomEvent } from '@area17/a17-helpers';

const youtubeEmbed = function(iframe) {
  const playedChecks = {
    25: false,
    50: false,
    75: false,
  };

  let youtubePlayer;
  let youtubePlayerTimer;

  function onPlayerEnded() {
    triggerCustomEvent(document, 'gtm:push', {
      'event': '100%',
      'eventCategory': 'video-engagement',
    });
  }

  function onPlayerPlaying() {
    triggerCustomEvent(document, 'gtm:push', {
      'event': 'playing',
      'eventCategory': 'video-engagement',
    });
    youtubePlayerTimer = setInterval(_checkPlayedPercent, 250);
  }

  function onPlayerPaused() {
    triggerCustomEvent(document, 'gtm:push', {
      'event': 'paused',
      'eventCategory': 'video-engagement',
    });
  }

  function _checkPlayedPercent() {
    const playedPercent = Math.round(youtubePlayer.getCurrentTime()/youtubePlayer.getDuration() * 100);
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

  function _onStateChange() {
    try {
      clearInterval(youtubePlayerTimer);
    } catch (err) {
      // noop
    }
    switch (youtubePlayer.getPlayerState()) {
      case YT.PlayerState.ENDED:
        triggerCustomEvent(iframe, 'youtube:ended', {id: iframe.id});
        onPlayerEnded();
        break;
      case YT.PlayerState.PLAYING:
        triggerCustomEvent(iframe, 'youtube:playing', {id: iframe.id});
        onPlayerPlaying();
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
    }
  }

  function _initYoutubePlayer() {
    if (A17.YouTubeonYouTubeIframeAPIReady) {
      youtubePlayer = new YT.Player(iframe.id, {
        videoId: iframe.id,
        playerVars: {
          'autoplay': 1,
          'enablejsapi': 1,
          'origin': window.location.origin
        },
        events: {
          'onStateChange': _onStateChange,
        },
      });
      A17.YouTubeembeds[iframe.id] = youtubePlayer;
      console.debug('youtubeEmbed added', iframe.id, A17.YouTubeembeds[iframe.id]);
    } else {
      console.debug("youtubeEmbed could't do it. Trying again is 250ms");
      setTimeout(_initYoutubePlayer, 250);
    }
  }

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

  _initYoutubePlayer();
};

function getYouTubePlayer(iframeId) {
  console.log(iframeId, A17.YouTube.embeds[iframeId]);
  return A17.YouTube.embeds[iframeId];
}

function controlYouTubePlayer(player, commands) {
  console.log(commands, player);
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
        player.stopVideo()
        break;
      default:
        // noop
        break;
    }
  }
}

export { getYouTubePlayer, controlYouTubePlayer, youtubeEmbed as default };
