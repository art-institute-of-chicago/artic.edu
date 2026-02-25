import { purgeProperties, setFocusOnTarget, scrollToY } from '@area17/a17-helpers';
import { getYouTubePlayer } from '../../functions/core/youtubeEmbed';

const controlYoutubeEmbed = function(container) {
  const embedId = container.dataset.embedId;

  async function handleClick(event) {
    event.preventDefault();
    event.stopPropagation();

    if (!embedId) {
      return;
    }

    const player = await getYouTubePlayer(embedId);
    console.log('controlYoutubeEmbed trying with', player);
    if (!player) {
      return;
    }

    const seekTo = Number(container.dataset.seekTo);

    if (!Number.isNaN(seekTo)) {
      console.log('controlYoutubeEmbed seekTo', 'player', player, 'container.dataset.seekTo', container.dataset.seekTo);
      player.seekTo(seekTo, true);
    }

    if (container.dataset.pauseVideo) {
      player.pauseVideo();
    } else if (container.dataset.stopVideo) {
      player.stopVideo();
    } else if (container.dataset.playVideo || !Number.isNaN(seekTo)) {
      player.playVideo();
    }

    const embed = document.getElementById(embedId);
    if (!embed) {
      return;
    }

    scrollToY({
      duration: 500,
      easing: 'easeInOut',
      onComplete: () => setTimeout(() => setFocusOnTarget(embed), 0),
    });
  }

  this.destroy = function() {
    container.removeEventListener('click', handleClick);
    purgeProperties(this);
  };

  this.init = function() {
    container.addEventListener('click', handleClick);
  };
};

export default controlYoutubeEmbed;
