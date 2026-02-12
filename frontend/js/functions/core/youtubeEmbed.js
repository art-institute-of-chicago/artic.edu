import { triggerCustomEvent } from '@area17/a17-helpers';

const youtubeEmbed = function(iframe) {
  let youtubePlayer;
  let youtubePlayerTimer;
  let playedChecks = {
    25: false,
    50: false,
    75: false,
    100: false
  };

  function _onYouTubePlayerPlaying() {
    let playedPercent = Math.round(youtubePlayer.getCurrentTime()/youtubePlayer.getDuration() * 100);
    for (let playedCheck in playedChecks) {
      let percentComparison = (playedCheck === 100) ? 99 : playedCheck;
      if (playedPercent >= percentComparison && !playedChecks[playedCheck]) {
        playedChecks[playedCheck] = true;
        triggerCustomEvent(document, 'gtm:push', {
          'event': playedCheck + '%',
          'eventCategory': 'video-engagement',
        });
      }
    }
  }

  function _onYouTubePlayerStateChange(event) {
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
      } catch(err){}
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
    let youtubeScript = document.createElement('script');
    youtubeScript.src = 'https://www.youtube.com/iframe_api';
    youtubeScript.id = 'youtubeapijs';
    let firstScript = document.getElementsByTagName('script')[0];
    firstScript.parentNode.insertBefore(youtubeScript, firstScript);
  }

  if (!iframe.id) {
    iframe.id = 'youtube_' + Math.random().toString(36).substr(2, 9);
  }

  _initYoutubePlayer();
};

export default youtubeEmbed;
