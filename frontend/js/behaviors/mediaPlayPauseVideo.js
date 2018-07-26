import { purgeProperties } from '@area17/a17-helpers';

const mediaPlayPauseVideo = function(container) {

  let paused = false;
  let video;

  function _paused() {
    paused = true;
    container.classList.add('s-paused');
    container.setAttribute('aria-label','Play video');
  }

  function _playing() {
    paused = false;
    container.classList.remove('s-paused');
    container.setAttribute('aria-label','Pause video');
  }

  function _handleClicks(event) {
    event.preventDefault();
    event.stopPropagation();
    if (!paused) {
      video.pause();
    } else {
      video.play();
    }
  }

  function _init() {
    video = container.parentNode.querySelector('video');
    if (video) {
      if (video.paused) {
        _paused()
      }
      container.addEventListener('click', _handleClicks, false);
      video.addEventListener('play', _playing, false);
      video.addEventListener('pause', _paused, false);
    }
  }

  this.destroy = function() {
    if (video) {
      container.removeEventListener('click', _handleClicks);
      video.removeEventListener('play', _playing);
      video.removeEventListener('pause', _paused);
    }
    video = null;
    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default mediaPlayPauseVideo;
