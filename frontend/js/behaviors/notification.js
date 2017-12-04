import { purgeProperties, forEach } from 'a17-helpers';

const notification = function(container) {

  let closers = container.querySelectorAll('[data-notification-closer]');

  function _afterAnimation() {
    this.parentNode.removeChild(this);
    container.removeEventListener('transitionend', _afterAnimation);
  }

  function _handleClicks(event) {
    event.preventDefault();
    event.stopPropagation();
    container.classList.add('s-hide');
    container.addEventListener('transitionend', _afterAnimation, false);
  }

  function _init() {
    console.log(closers);
    forEach(closers, function(index, closer) {
      closer.addEventListener('click', _handleClicks, false);
    });
  }

  this.destroy = function() {
    // remove specific event handlers
    forEach(closers, function(index, closer) {
      closer.removeEventListener('click', _handleClicks);
    });
    closers = undefined;
    // remove properties of this behavior
    purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default notification;
