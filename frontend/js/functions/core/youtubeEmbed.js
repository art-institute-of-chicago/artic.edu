import { triggerCustomEvent } from '@area17/a17-helpers';

const youtubeEmbed = function(iframe) {
  const playedChecks = {
    25: false,
    50: false,
    75: false,
    100: false
  };

  let youtubePlayer;
  let youtubePlayerTimer;

  function _onYouTubePlayerPlaying() {
    const playedPercent = Math.round(youtubePlayer.getCurrentTime()/youtubePlayer.getDuration() * 100);
    for (const playedCheck in playedChecks) {
      const percentComparison = (playedCheck === 100) ? 99 : playedCheck;
      if (playedPercent >= percentComparison && !playedChecks[playedCheck]) {
        playedChecks[playedCheck] = true;
        triggerCustomEvent(document, 'gtm:push', {
          'event': `${playedCheck}%`,
          'eventCategory': 'video-engagement',
        });
      }
    }
  }

  function _onYouTubePlayerStateChange() {
    if (youtubePlayer.getPlayerState() === 1) {
      youtubePlayerTimer = setInterval(_onYouTubePlayerPlaying,250);
      triggerCustomEvent(document, 'gtm:push', {
        'event': 'playing',
        'eventCategory': 'video-engagement',
      });
    } else {
      if (youtubePlayer.getPlayerState() === 2) {
        triggerCustomEvent(document, 'gtm:push', {
          'event': 'paused',
          'eventCategory': 'video-engagement',
        });
      }
      try {
        clearInterval(youtubePlayerTimer);
      } catch(err) {
        // noop
      }
    }
  }

  function _initYoutubePlayer() {
    if (A17.onYouTubeIframeAPIReady) {
      youtubePlayer = new YT.Player(iframe.id, {
        playerVars: {
          'enablejsapi': 1,
          'origin': window.location.origin,
        },
        events: {
          'onStateChange': _onYouTubePlayerStateChange,
        },
      });
    } else {
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

export default youtubeEmbed;
