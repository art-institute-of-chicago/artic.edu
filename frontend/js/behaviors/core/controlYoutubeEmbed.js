import { purgeProperties, setFocusOnTarget, scrollToY } from '@area17/a17-helpers';
import { getYouTubePlayer } from '../../functions/core/youtubeEmbed';

const controlYoutubeEmbed = function(container) {
  const embedId = container.dataset.embedId;

  async function handleClick(event) {
    event.preventDefault();
    event.stopPropagation();

    let player = await getYouTubePlayer(embedId);

    console.log('controlYoutubeEmbed trying with', player);

    if (container.dataset.playVideo) {
      player.playVideo();
    }
    else if (container.dataset.pauseVideo) {
      player.pauseVideo();
    }
    else if (container.dataset.stopVideo) {
      player.stopVideo();
    }

    if (container.dataset.seekTo) {
      console.log('controlYoutubeEmbed seekTo', 'player', player, 'container.dataset.seekTo', container.dataset.seekTo);
      player.seekTo(container.dataset.seekTo, true);
    }


    let embed = document.getElementById(embedId);
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
