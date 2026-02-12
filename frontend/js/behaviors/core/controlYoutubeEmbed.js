import { purgeProperties, setFocusOnTarget, scrollToY } from '@area17/a17-helpers';

const controlYoutubeEmbed = function(container) {
  const embedId = container.dataset.embedId;
  const embed = document.getElementById(embedId);

  function handleClick(event) {
    event.preventDefault();
    event.stopPropagation();

    let player = A17.YouTube.embeds[embedId];
    for (let command in container.dataset) {
      console.log(command);
      switch (command) {
        case 'pauseVideo':
          player.pauseVideo();
          break;
        case 'playVideo':
          player.playVideo();
          break;
        case 'stopVideo':
          player.stopVideo()
          break;
        case 'seekTo':
          player.seekTo(container.dataset[command], true)
          break;
        default:
          // noop
          break;
      }
    }

    scrollToY({
      duration: 500,
      easing: 'easeInOut',
      onComplete: function() {
        setTimeout(function() {
          setFocusOnTarget(embed);
        }, 0)
      },
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
