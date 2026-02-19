import { purgeProperties, setFocusOnTarget, scrollToY } from '@area17/a17-helpers';
import { getYouTubePlayer, controlYouTubePlayer } from '../../functions/core/youtubeEmbed';

const controlYoutubeEmbed = function(container) {
  const embedId = container.dataset.embedId;
  if (!embedId) {
    console.error('controlYoutubeEmbed: No target <iframe> embed ID provided!');
  }
  const embed = document.getElementById(embedId);

  function handleClick(event) {
    event.preventDefault();
    event.stopPropagation();

    const player = getYouTubePlayer(embedId);
    if (!player) {
      return false;
    }
    controlYouTubePlayer(player, container.dataset)

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
