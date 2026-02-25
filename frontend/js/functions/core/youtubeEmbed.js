import { triggerCustomEvent } from '@area17/a17-helpers';

/**
 * This file was largely created by GPT-5.3-Codex during a
 * refactor for ticket [WEB-3280]. ntrivedi, 02.25.2026
 */

const YOUTUBE_API_SCRIPT_ID = 'youtubeapijs';
const POLL_DELAY_MS = 250;

function isPromiseLike(value) {
  return !!value && typeof value.then === 'function';
}

function isValidPlayer(player) {
  return !!player
    && typeof player.playVideo === 'function'
    && typeof player.pauseVideo === 'function'
    && typeof player.seekTo === 'function';
}

function ensureEmbedStore() {
  if (!A17.YouTubeembeds || typeof A17.YouTubeembeds !== 'object') {
    A17.YouTubeembeds = {};
  }
}

function ensureIframeId(iframe) {
  if (!iframe.id) {
    iframe.id = `youtube_${Math.random().toString(36).substring(2, 9)}`;
  }

  return iframe.id;
}

function injectYouTubeApiScript() {
  if (document.getElementById(YOUTUBE_API_SCRIPT_ID)) {
    return;
  }

  const youtubeScript = document.createElement('script');
  youtubeScript.src = 'https://www.youtube.com/iframe_api';
  youtubeScript.id = YOUTUBE_API_SCRIPT_ID;

  const firstScript = document.getElementsByTagName('script')[0];
  firstScript.parentNode.insertBefore(youtubeScript, firstScript);
}

function waitForYouTubeApiReady() {
  injectYouTubeApiScript();

  return new Promise((resolve) => {
    const check = () => {
      if (A17.YouTubeonYouTubeIframeAPIReady && window.YT && typeof YT.Player === 'function') {
        resolve();
        return;
      }

      setTimeout(check, POLL_DELAY_MS);
    };

    check();
  });
}

function normalizeCacheEntry(iframeId) {
  ensureEmbedStore();

  const cached = A17.YouTubeembeds[iframeId];
  if (!cached) {
    return null;
  }

  if (isPromiseLike(cached)) {
    return {
      playerPromise: cached,
      iframe: null,
      player: null,
    };
  }

  if (isValidPlayer(cached)) {
    return {
      playerPromise: Promise.resolve(cached),
      iframe: typeof cached.getIframe === 'function' ? cached.getIframe() : null,
      player: cached,
    };
  }

  if (cached && isPromiseLike(cached.playerPromise)) {
    return {
      playerPromise: cached.playerPromise,
      iframe: cached.iframe || null,
      player: cached.player || null,
    };
  }

  return null;
}

function setCacheEntry(iframeId, playerPromise, iframe, player = null) {
  ensureEmbedStore();

  A17.YouTubeembeds[iframeId] = {
    playerPromise,
    iframe,
    player,
  };

  console.debug('youtubeEmbed added', iframeId, A17.YouTubeembeds[iframeId]);
}

function createStateChangeHandler(iframe) {
  const playedChecks = {
    25: false,
    50: false,
    75: false,
    100: false,
  };

  let youtubePlayerTimer;

  function onPlayerPlaying(player) {
    const duration = player.getDuration();
    if (!duration) {
      return;
    }

    const playedPercent = Math.round((player.getCurrentTime() / duration) * 100);

    for (let playedCheck in playedChecks) {
      const percentComparison = (playedCheck === '100') ? 99 : Number(playedCheck);

      if (playedPercent >= percentComparison && !playedChecks[playedCheck]) {
        playedChecks[playedCheck] = true;
        triggerCustomEvent(document, 'gtm:push', {
          event: `${playedCheck}%`,
          eventCategory: 'video-engagement',
        });
      }
    }
  }

  return function onStateChange(event) {
    const player = event.target;

    if (player.getPlayerState() === 1) {
      clearInterval(youtubePlayerTimer);
      youtubePlayerTimer = setInterval(() => onPlayerPlaying(player), POLL_DELAY_MS);

      triggerCustomEvent(document, 'gtm:push', {
        event: 'playing',
        eventCategory: 'video-engagement',
      });

      triggerCustomEvent(iframe, 'youtube:playing', { id: iframe.id });
      return;
    }

    if (player.getPlayerState() === 2) {
      triggerCustomEvent(document, 'gtm:push', {
        event: 'paused',
        eventCategory: 'video-engagement',
      });
    }

    clearInterval(youtubePlayerTimer);
  };
}

function createPlayerPromise(iframeId, options = {}) {
  const {
    autoplay = false,
    onStateChange,
  } = options;

  return new Promise((resolve) => {
    let playerInstance;

    playerInstance = new YT.Player(iframeId, {
      playerVars: {
        autoplay: autoplay ? 1 : 0,
        enablejsapi: 1,
        origin: window.location.origin,
      },
      events: {
        onReady: () => resolve(playerInstance),
        onStateChange,
      },
    });
  });
}

async function getOrCreateYouTubePlayer(iframe, options = {}) {
  const iframeId = ensureIframeId(iframe);

  await waitForYouTubeApiReady();

  const cachedEntry = normalizeCacheEntry(iframeId);

  if (cachedEntry) {
    const cachedPlayer = await cachedEntry.playerPromise;

    if (isValidPlayer(cachedPlayer)) {
      const cachedIframe = typeof cachedPlayer.getIframe === 'function' ? cachedPlayer.getIframe() : cachedEntry.iframe;
      if (!cachedIframe || cachedIframe === iframe) {
        setCacheEntry(iframeId, Promise.resolve(cachedPlayer), iframe, cachedPlayer);
        return cachedPlayer;
      }

      if (typeof cachedPlayer.destroy === 'function') {
        cachedPlayer.destroy();
      }
    }
  }

  const playerPromise = createPlayerPromise(iframeId, options);
  setCacheEntry(iframeId, playerPromise, iframe);

  const player = await playerPromise;
  setCacheEntry(iframeId, Promise.resolve(player), iframe, player);

  return player;
}

const youtubeEmbed = function(iframe) {
  if (!iframe) {
    return;
  }

  getOrCreateYouTubePlayer(iframe, {
    onStateChange: createStateChangeHandler(iframe),
  });
};

async function getYouTubePlayer(iframeId) {
  await waitForYouTubeApiReady();

  const iframe = document.getElementById(iframeId);
  if (!iframe) {
    return new Promise((resolve) => {
      setTimeout(() => {
        getYouTubePlayer(iframeId).then(resolve);
      }, POLL_DELAY_MS);
    });
  }

  return getOrCreateYouTubePlayer(iframe);
}

export { getYouTubePlayer, youtubeEmbed as default };
