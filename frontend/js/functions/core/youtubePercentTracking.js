import { triggerCustomEvent } from '@area17/a17-helpers';

const youtubePercentTracking = function(iframe) {
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
        origin: window.location.origin,
        events: {
          'onStateChange': _onYouTubePlayerStateChange
        }
      });
    } else {
      setTimeout(_initYoutubePlayer, 250);
    }
  }

  if (!document.getElementById('youtubeapijs')) {
    let tag = document.createElement('script');
    tag.src = 'https://www.youtube.com/iframe_api';
    tag.id = 'youtubeapijs';
    let firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
  }

  if (!iframe.id) {
    iframe.id = 'youtube_' + Math.random().toString(36).substr(2, 9);
  }

  _initYoutubePlayer();
};

export default youtubePercentTracking;
