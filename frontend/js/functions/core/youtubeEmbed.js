import { triggerCustomEvent } from '@area17/a17-helpers';

// Load the YouTube IFrame API once, as soon as this module runs (page load),
// rather than waiting for the first embed to be created. An embed's iframe
// starts loading its own content the moment it's inserted into the DOM, and
// broadcasts a "ready" handshake to whichever code is listening for it at
// that moment. If the IFrame API is still loading when that happens (because
// it was only requested on-demand), the handshake is missed and that
// player's event listeners (onReady/onStateChange) never attach. Giving the
// API a head start at page load avoids that race for every embed, including
// the first one created in a fresh document.
function _loadYouTubeIframeApi() {
  return new Promise((resolve) => {
    if (window.YT && window.YT.Player) {
      resolve();
      return;
    }
    window.onYouTubeIframeAPIReady = resolve;
    if (!document.getElementById('youtubeapijs')) {
      const youtubeScript = document.createElement('script');
      youtubeScript.src = 'https://www.youtube.com/iframe_api';
      youtubeScript.id = 'youtubeapijs';
      const firstScript = document.getElementsByTagName('script')[0];
      firstScript.parentNode.insertBefore(youtubeScript, firstScript);
    }
  });
}

const youtubeApiReady = _loadYouTubeIframeApi();

const youtubeEmbed = function(iframe) {
  if (!(iframe instanceof Element)) {
    iframe = document.getElementById(iframe);
  }

  const playedChecks = {
    25: false,
    50: false,
    75: false,
  };

  let youtubePlayerTimer;
  let currentVideoId = null;

  function onPlayerEnded(player) {
    triggerCustomEvent(document, 'gtm:push', {
      'event': 'gtm.video',
      'gtm.videoStatus': 'complete',
      'gtm.videoTitle': player.getVideoData().title,
      'gtm.videoUrl': player.getVideoUrl(),
      'gtm.videoDuration': player.getDuration(),
      'gtm.videoCurrentTime': player.getCurrentTime(),
      'gtm.videoPercent': _playedPercent(player),
      'gtm.videoVisible': true,
    });
  }

  function onPlayerPlaying(player) {
    const videoId = player.getVideoData().video_id;
    const status = videoId !== currentVideoId ? 'start' : 'resume';
    if (status === 'start') {
      // A new video is playing (as opposed to a resume after pause/buffer).
      // Track it and reset the played-percent checks so progress is tracked
      // for this video instead of carrying over thresholds already hit by a
      // previous video in the same player (e.g. advancing between shorts).
      currentVideoId = videoId;
      for (const playedCheck in playedChecks) {
        playedChecks[playedCheck] = false;
      }
    }
    triggerCustomEvent(document, 'gtm:push', {
      'event': 'gtm.video',
      'gtm.videoStatus': status,
      'gtm.videoTitle': player.getVideoData().title,
      'gtm.videoUrl': player.getVideoUrl(),
      'gtm.videoDuration': player.getDuration(),
      'gtm.videoCurrentTime': player.getCurrentTime(),
      'gtm.videoPercent': _playedPercent(player),
      'gtm.videoVisible': true,
    });
    youtubePlayerTimer = setInterval(() => _checkPlayedPercent(player), 250);
  }

  function onPlayerPaused(player) {
    // Before playing a new video, the player pauses the current video and sets
    // it's duration to 0. We only want to push user-initiated pause data to
    // GTM.
    if (player.getDuration() > 0) {
      triggerCustomEvent(document, 'gtm:push', {
        'event': 'gtm.video',
        'gtm.videoStatus': 'pause',
        'gtm.videoTitle': player.getVideoData().title,
        'gtm.videoUrl': player.getVideoUrl(),
        'gtm.videoDuration': player.getDuration(),
        'gtm.videoCurrentTime': player.getCurrentTime(),
        'gtm.videoPercent': _playedPercent(player),
        'gtm.videoVisible': true,
      });
    }
  }

  function _playedPercent(player) {
    return Math.round(player.getCurrentTime() / player.getDuration() * 100);
  }

  function _checkPlayedPercent(player) {
    const playedPercent = _playedPercent(player);
    for (const playedCheck in playedChecks) {
      if (playedPercent >= playedCheck && !playedChecks[playedCheck]) {
        playedChecks[playedCheck] = true;
        triggerCustomEvent(document, 'gtm:push', {
          'event': 'gtm.video',
          'gtm.videoStatus': 'progress',
          'gtm.videoTitle': player.getVideoData().title,
          'gtm.videoUrl': player.getVideoUrl(),
          'gtm.videoDuration': player.getDuration(),
          'gtm.videoCurrentTime': player.getCurrentTime(),
          'gtm.videoPercent': _playedPercent(player),
          'gtm.videoVisible': true,
        });
      }
    }
  }

  function _onReady(event) {
    const player = event.target;
    try {
      iframe = player.getIframe();
    } catch(e) {
      return;
    }
    if (iframe.id in AIC.YouTubeembeds) return;
    AIC.YouTubeembeds[iframe.id] = player;
    console.log(AIC.YouTubeembeds);
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
        onPlayerEnded(event.target);
        break;
      case YT.PlayerState.PLAYING:
        triggerCustomEvent(iframe, 'youtube:playing', {id: iframe.id});
        onPlayerPlaying(event.target);
        break;
      case YT.PlayerState.PAUSED:
        triggerCustomEvent(iframe, 'youtube:paused', {id: iframe.id});
        onPlayerPaused(event.target);
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
    if (iframeId in AIC.YouTubeembeds) return;
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
  };

  if (!iframe.id) {
    iframe.id = `youtube_${Math.random().toString(36).substring(2, 9)}`;
  }
  youtubeApiReady.then(() => _initYoutubePlayer(iframe.id));
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
  controlYouTubePlayer(AIC.YouTubeembeds[iframe.id], { 'destroy': true });
  delete AIC.YouTubeembeds[iframe.id];
}

export { controlYouTubePlayer, unsetEmbed, youtubeEmbed as default };
