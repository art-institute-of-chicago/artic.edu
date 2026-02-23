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
    let playedPercent = Math.round(youtubePlayer.getCurrentTime()/youtubePlayer.getDuration() * 100);
    for (let playedCheck in playedChecks) {
      let percentComparison = (playedCheck === 100) ? 99 : playedCheck;
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
      triggerCustomEvent(iframe, 'youtube:playing', {id: iframe.id});
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
    if (A17.YouTubeonYouTubeIframeAPIReady) {
      youtubePlayer = new YT.Player(iframe.id, {
        videoId: iframe.id,
        playerVars: {
          'enablejsapi': 1,
          'origin': window.location.origin
        },
        events: {
          'onStateChange': _onYouTubePlayerStateChange
        }
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

async function getYouTubePlayer(iframeId) {
  return new Promise((resolve) => {
    if (A17.YouTubeonYouTubeIframeAPIReady) {
      if (!(iframeId in A17.YouTubeembeds)) {
        const playerPromise = new Promise((playerResolve) => {
          A17.YouTubeembeds[iframeId] = new YT.Player(iframeId, {
            playerVars: {
              'autoplay': 1,
              'enablejsapi': 1,
              'origin': window.location.origin,
            },
            events: {
              'onReady': () => playerResolve(A17.YouTubeembeds[iframeId]),
            },
          });
        });
        playerPromise.then(resolve);
      } else {
        resolve(A17.YouTubeembeds[iframeId]);
      }
    } else {
      setTimeout(() => getYouTubePlayer(iframeId).then(resolve), 250);
    }
  });
};

export { getYouTubePlayer, youtubeEmbed as default };
