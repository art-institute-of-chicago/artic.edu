import youtubeEmbed, { controlYouTubePlayer } from './youtubeEmbed';

const SHORTS_PLAYER_ID = 'shorts-player-iframe';
const SHORTS_LIST_SELECTOR = '#shorts-list';
const VIEWPORT_SELECTOR = '[data-type="embed"]';
const SHORT_VIDEO_SELECTOR = '.short-video';
const CURRENT_VIDEO_CLASS = 'current-video';
const CURRENT_VIDEO_SELECTOR = `li.${CURRENT_VIDEO_CLASS}`;
const PREVIOUS_VIDEO_CLASS = 'previous-video';
const PREVIOUS_VIDEO_SELECTOR = `li.${PREVIOUS_VIDEO_CLASS}`;
const NEXT_VIDEO_CLASS = 'next-video';
const NEXT_VIDEO_SELECTOR = `li.${NEXT_VIDEO_CLASS}`;

const shortsPlayer = async function(container) {
  console.log('shortsPlayer');

  async function init() {
    console.log('init');
    const iframe = container.querySelector('iframe');
    if (!iframe) {
      return false;
    }
    iframe.id = SHORTS_PLAYER_ID;
    await youtubeEmbed(SHORTS_PLAYER_ID);
    iframe.addEventListener('youtube:ended', _handleEnded);

    const list = container.querySelector(SHORTS_LIST_SELECTOR);
    const currentVideo = list.querySelector(CURRENT_VIDEO_SELECTOR);
    await _scrollToVideo(currentVideo, 'instant');

    const videos = list.querySelectorAll(SHORT_VIDEO_SELECTOR);
    videos.forEach((video) => video.addEventListener('click', _handleClick));

    list.addEventListener('scrollend', _handleScrollEnd);
  }

  function _handleClick(event) {
    console.log('handleClick');
    const selectedItem = event.currentTarget;
    if (selectedItem.classList.contains(PREVIOUS_VIDEO_CLASS) || selectedItem.classList.contains(NEXT_VIDEO_CLASS)) {
      _scrollToVideo(selectedItem);
    }
  }

  function _handleEnded() {
    console.log('handleEnded');
    let nextVideo = container.querySelector(NEXT_VIDEO_SELECTOR);
    _scrollToVideo(nextVideo);
  }

  async function _scrollToVideo(video, behavior='smooth') {
    console.log('scrollToVideo');
    const list = container.querySelector(SHORTS_LIST_SELECTOR);
    const listScrolled = list.scrollLeft;
    const listBounds = list.getBoundingClientRect();
    const videoBounds = video.getBoundingClientRect();
    const videoCenter = videoBounds.x + (videoBounds.width / 2);
    const listCenter = listBounds.width / 2;
    let toLeft = listScrolled + videoCenter - listCenter;
    console.log(listScrolled, videoCenter, listCenter, toLeft);
    list.scrollTo({
      top: 0,
      left: toLeft,
      behavior: behavior,
    });
  }

  async function _handleScrollEnd() {
    console.log('handleScrollEnd');
    const list = container.querySelector(SHORTS_LIST_SELECTOR);
    const bounds = list.getBoundingClientRect();
    // console.log(bounds);
    let centerX = (bounds.width / 2) + bounds.x;
    let centerY = (bounds.height / 2) + bounds.y;
    const centeredElement = document.elementFromPoint(centerX, centerY);
    const centeredVideo = centeredElement.closest(SHORT_VIDEO_SELECTOR);
    console.log('centeredVideo', centeredVideo);
    _moveViewportToVideo(centeredVideo);
  }

  async function _moveViewportToVideo(video) {
    console.log('moveViewportToVideo');
    const viewport = container.querySelector(VIEWPORT_SELECTOR);
    const list = container.querySelector(SHORTS_LIST_SELECTOR);
    const currentVideo = list.querySelector(CURRENT_VIDEO_SELECTOR);
    if (video === currentVideo) {
      console.log('same video');
      return;
    }
    let player = await youtubeEmbed(SHORTS_PLAYER_ID);
    controlYouTubePlayer(player, video.dataset);
    _updateCurrentVideo(video);
    video.moveBefore(viewport, video.firstChild);
  }

  function _updateCurrentVideo(currentVideo) {
    console.log('updateCurrentVideo');
    container.querySelector(CURRENT_VIDEO_SELECTOR)?.classList.remove(CURRENT_VIDEO_CLASS);
    currentVideo.classList.add(CURRENT_VIDEO_CLASS);

    container.querySelector(PREVIOUS_VIDEO_SELECTOR)?.classList.remove(PREVIOUS_VIDEO_CLASS);
    currentVideo.previousElementSibling?.classList.add(PREVIOUS_VIDEO_CLASS);

    container.querySelector(NEXT_VIDEO_SELECTOR)?.classList.remove(NEXT_VIDEO_CLASS);
    currentVideo.nextElementSibling?.classList.add(NEXT_VIDEO_CLASS);
  }

  document.addEventListener('ajaxPageLoad:complete', event => init());
};

export default shortsPlayer;
