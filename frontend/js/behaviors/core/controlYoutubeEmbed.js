import { purgeProperties, setFocusOnTarget, scrollToY } from '@area17/a17-helpers';
import { controlYouTubePlayer } from '../../functions/core/youtubeEmbed';

const controlYoutubeEmbed = function(container) {
  const embedId = container.dataset.embedId;
  if (!embedId) {
    console.error('controlYoutubeEmbed: No target <iframe> embed ID provided!');
    return;
  }

  let player;

  function handleClick(event) {
    event.preventDefault();
    event.stopPropagation();

    controlYouTubePlayer(player, container.dataset)
    scrollToY({
      duration: 500,
      easing: 'easeInOut',
      onComplete: () => setTimeout(() => setFocusOnTarget(player.getIframe()), 0),
    });
  }

  this.destroy = function() {
    container.removeEventListener('click', handleClick);
    purgeProperties(this);
  };

  this.init = function() {
    const iframe = document.getElementById(embedId);
    iframe.addEventListener('youtube:ready', (event) => {
      player = event.data.player;
      container.addEventListener('click', handleClick);
    });
  };
};

export default controlYoutubeEmbed;
