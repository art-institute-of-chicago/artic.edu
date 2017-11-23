import { purgeProperties, setFocusOnTarget, scrollToY } from 'a17-helpers';

const topLink = function(container) {

  function _handleClicks(event) {
    event.preventDefault();
    container.blur();
    window.location.hash = '';
    scrollToY({
      el: document,
      offset: 0,
      duration: 250,
      easing: 'easeInOut',
      onComplete: function() {
        setFocusOnTarget(document.getElementById('a17'));
      }
    });
  }

  function _init() {
    container.addEventListener('click', _handleClicks, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    container.removeEventListener('click', _handleClicks);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default topLink;
