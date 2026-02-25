import { purgeProperties, setFocusOnTarget, scrollToY } from '@area17/a17-helpers';
import youtubeEmbed, { controlYouTubePlayer } from '../../functions/core/youtubeEmbed';

const controlYoutubeEmbed = function(container) {
  const embedId = container.dataset.embedId;
  if (!embedId) {
    console.error('controlYoutubeEmbed: No target <iframe> embed ID provided!');
  }
  const embed = document.getElementById(embedId);

  async function handleClick(event) {
    event.preventDefault();
    event.stopPropagation();

    const player = await youtubeEmbed(embedId);
    controlYouTubePlayer(player, container.dataset)

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
