import youtubeEmbed, { controlYouTubePlayer, getYouTubePlayer } from './youtubeEmbed';

const SHORTS_PLAYER_ID = 'shorts-player-iframe';
const VIEWPORT_SELECTOR = '[data-type="embed"]';
const SHORT_VIDEO_SELECTOR = '.short-video';
const CURRENT_VIDEO_CLASS = 'current-video';
const CURRENT_VIDEO_SELECTOR = `li.${CURRENT_VIDEO_CLASS}`;
const PREVIOUS_VIDEO_CLASS = 'previous-video';
const PREVIOUS_VIDEO_SELECTOR = `li.${PREVIOUS_VIDEO_CLASS}`;
const NEXT_VIDEO_CLASS = 'next-video';
const NEXT_VIDEO_SELECTOR = `li.${NEXT_VIDEO_CLASS}`;

const shortsPlayer = function(container) {
  const iframe = container.querySelector('iframe');
  if (!iframe) {
    return false;
  }
  iframe.id = SHORTS_PLAYER_ID;
  youtubeEmbed(iframe);
  iframe.addEventListener('youtube:ended', _handleEnded);

  const viewport = container.querySelector(VIEWPORT_SELECTOR);
  const shorts = container.querySelectorAll(SHORT_VIDEO_SELECTOR);
  shorts.forEach((short) => short.addEventListener('click', _handleClick));

  function _handleEnded(event) {
    console.log('ended');
    let nextVideoItem = container.querySelector(NEXT_VIDEO_SELECTOR);
    _moveViewportToVideoItem(nextVideoItem);
  }

  function _handleClick(event) {
    console.log('click');
    const selectedItem = event.currentTarget;
    _moveViewportToVideoItem(selectedItem);
  }

  function _moveViewportToVideoItem(videoItem) {
    const player = getYouTubePlayer(SHORTS_PLAYER_ID);
    controlYouTubePlayer(player, videoItem.dataset);
    _updateCurrentVideoItem(videoItem);
    videoItem.moveBefore(viewport, videoItem.firstChild);
  }

  function _updateCurrentVideoItem(currentVideoItem) {
    container.querySelector(CURRENT_VIDEO_SELECTOR)?.classList.remove(CURRENT_VIDEO_CLASS);
    currentVideoItem.classList.add(CURRENT_VIDEO_CLASS);

    container.querySelector(PREVIOUS_VIDEO_SELECTOR)?.classList.remove(PREVIOUS_VIDEO_CLASS);
    currentVideoItem.previousElementSibling?.classList.add(PREVIOUS_VIDEO_CLASS);

    container.querySelector(NEXT_VIDEO_SELECTOR)?.classList.remove(NEXT_VIDEO_CLASS);
    currentVideoItem.nextElementSibling?.classList.add(NEXT_VIDEO_CLASS);
  }

  return true;
};

export default shortsPlayer;
