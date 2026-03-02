import youtubeEmbed, { controlYouTubePlayer } from './youtubeEmbed';
import { ajaxRequestCustom, parseHTML } from '.';

const SHORTS_PLAYER_ID = 'shorts-player-iframe';
const SHORTS_LIST_SELECTOR = '#shorts-list';
const EMBED_SELECTOR = 'iframe';
const VIEWPORT_SELECTOR = '[data-type="embed"]';
const COVER_IMAGE_SELECTOR = '[data-type="image"]';
const SHORT_VIDEO_SELECTOR = '.short-video';
const CURRENT_VIDEO_CLASS = 'current-video';
const CURRENT_VIDEO_SELECTOR = `li.${CURRENT_VIDEO_CLASS}`;
const PREVIOUS_ARROW_SELECTOR = '.previous-arrow';
const PREVIOUS_VIDEO_CLASS = 'previous-video';
const PREVIOUS_VIDEO_SELECTOR = `li.${PREVIOUS_VIDEO_CLASS}`;
const NEXT_ARROW_SELECTOR = '.next-arrow';
const NEXT_VIDEO_CLASS = 'next-video';
const NEXT_VIDEO_SELECTOR = `li.${NEXT_VIDEO_CLASS}`;
const FIRST_VIDEO_SELECTOR = `${SHORT_VIDEO_SELECTOR}:first-child`;
const LAST_VIDEO_SELECTOR = `${SHORT_VIDEO_SELECTOR}:last-child`;

const shortsPlayer = async function(container) {
  console.debug('shortsPlayer');
  const list = container.querySelector(SHORTS_LIST_SELECTOR);
  const viewport = container.querySelector(VIEWPORT_SELECTOR);
  const previousArrow = container.querySelector(PREVIOUS_ARROW_SELECTOR);
  const nextArrow = container.querySelector(NEXT_ARROW_SELECTOR);
  const embed = container.querySelector(EMBED_SELECTOR);
  if (!embed) {
    return false;
  }
  embed.id = SHORTS_PLAYER_ID;
  await youtubeEmbed(embed);
  _init();

  async function _init() {
    const currentVideo = list.querySelector(CURRENT_VIDEO_SELECTOR);
    await _scrollToVideo(currentVideo, 'instant');
    embed.addEventListener('youtube:ended', _handleEnded);
    list.addEventListener('scrollend', _handleScrollEnd);
    const videos = list.querySelectorAll(SHORT_VIDEO_SELECTOR);
    videos.forEach((video) => video.addEventListener('click', _handleClick));
  }

  function _handleClick(event) {
    console.debug('handleClick');
    const selectedItem = event.currentTarget;
    console.log(selectedItem);
    if (selectedItem.classList.contains('previous-video') || selectedItem.classList.contains('next-video')) {
      _scrollToVideo(selectedItem);
    }
  }

  function _handleEnded() {
    console.debug('handleEnded');
    const nextVideo = container.querySelector(NEXT_VIDEO_SELECTOR);
    if (nextVideo) {
      _scrollToVideo(nextVideo);
    }
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
    console.log(listScrolled, videoCenter, listCenter, toLeft, behavior);
    list.scrollTo({
      top: 0,
      left: toLeft,
      behavior: behavior,
    });
  }

  function _handleScrollEnd() {
    console.debug('handleScrollEnd');
    const bounds = list.getBoundingClientRect();
    let centerX = (bounds.width / 2) + bounds.x;
    let centerY = (bounds.height / 2) + bounds.y;
    const centeredElement = document.elementFromPoint(centerX, centerY);
    const centeredVideo = centeredElement.closest(SHORT_VIDEO_SELECTOR);
    _moveViewportToVideo(centeredVideo);
  }

  async function _moveViewportToVideo(video) {
    console.debug('moveViewportToVideo');
    const currentVideo = list.querySelector(CURRENT_VIDEO_SELECTOR);
    if (video === currentVideo) {
      // The snap-to scrolling can cause `scrollend` to fire multiple times on
      // the same video.
      console.debug('Same video, noop')
      return;
    }
    container.addEventListener('youtube:playing', () => {
      _updateVideoNavigation(video);
      list.classList.remove('s-moving-viewport');
      _loadMore();
    }, { once: true });
    list.classList.add('s-moving-viewport');
    const player = await youtubeEmbed(SHORTS_PLAYER_ID);
    controlYouTubePlayer(player, video.dataset);
  }

  function _loadMore() {
    console.debug('loadMore');
    const currentVideo = container.querySelector(CURRENT_VIDEO_SELECTOR);
    const firstVideo = list.querySelector(FIRST_VIDEO_SELECTOR);
    const lastVideo = list.querySelector(LAST_VIDEO_SELECTOR);
    let path = '';
    if (currentVideo == firstVideo) {
      path = 'previous';
    } else if (currentVideo == lastVideo) {
      path = 'next';
    } else {
      return; // Unless this is the first or last video, do not load any more
    }
    ajaxRequestCustom({
      url: `/videos/shorts/${currentVideo.id}/${path}`,
      type: 'GET',
      onSuccess: function(response, status) {
        console.debug(status)
        const html = parseHTML(response, 'native');
        if (path == 'previous') {
          Array.from(html.querySelectorAll('li')).reverse().forEach((video) => list.insertBefore(video, list.firstChild));
        }
        if (path == 'next') {
          html.querySelectorAll('li').forEach((video) => list.appendChild(video));
        }
        const videos = list.querySelectorAll(SHORT_VIDEO_SELECTOR);
        videos.forEach((video) => video.addEventListener('click', _handleClick));
        _updateVideoNavigation(currentVideo);
      },
    });
  }

  function _updateVideoNavigation(video) {
    console.debug('updateVideoNavigation');
    _updateCurrentVideo(video);
    _updatePreviousVideo(video.previousElementSibling);
    _updateNextVideo(video.nextElementSibling);
  }

  function _updateCurrentVideo(currentVideo) {
    console.debug('updateCurrentVideo');
    const oldCurrentVideo = container.querySelector(CURRENT_VIDEO_SELECTOR);
    oldCurrentVideo.classList.remove(CURRENT_VIDEO_CLASS);
    currentVideo.classList.add(CURRENT_VIDEO_CLASS);
    // Move the viewport on top of the current video's cover image
    currentVideo.moveBefore(viewport, currentVideo.firstChild);
  }

  function _updatePreviousVideo(previousVideo) {
    console.debug('updatePreviousVideo');
    const oldPreviousVideo = container.querySelector(PREVIOUS_VIDEO_SELECTOR);
    oldPreviousVideo?.classList.remove(PREVIOUS_VIDEO_CLASS);
    if (previousVideo) {
      previousVideo.classList.add(PREVIOUS_VIDEO_CLASS);
      previousArrow.style.display = 'block';
      // Move the "previous arrow" to the previous video, after the cover image
      previousVideo.moveBefore(previousArrow, null);
    } else {
      previousArrow.style.display = 'none';
    }
  }

  function _updateNextVideo(nextVideo) {
    console.debug('updateNextVideo');
    const oldNextVideo = container.querySelector(NEXT_VIDEO_SELECTOR);
    oldNextVideo?.classList.remove(NEXT_VIDEO_CLASS);
    if (nextVideo) {
      nextVideo.classList.add(NEXT_VIDEO_CLASS);
      nextArrow.style.display = 'block';
      // Move the "next arrow" to the next video, before the cover image
      nextVideo.moveBefore(nextArrow, nextVideo.querySelector(COVER_IMAGE_SELECTOR));
    } else {
      nextArrow.style.display = 'none';
    }
  }

  return true;
};

export default shortsPlayer;
