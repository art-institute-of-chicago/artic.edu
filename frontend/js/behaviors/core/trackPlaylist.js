import { triggerCustomEvent, purgeProperties } from '@area17/a17-helpers';

const triggerShortsPlayerModal = function(container) {
  this.destroy = function() {
    purgeProperties(this);
  };

  this.init = function() {
    const data = container.dataset;
    triggerCustomEvent(document, 'gtm:push', {
      'playlist_id': data.playlistId,
      'playlist_title': data.playlistTitle,
      'playlist_position': data.playlistPosition,
    });
  };
};

export default triggerShortsPlayerModal;
