import { purgeProperties, forEach, ajaxRequest } from '@area17/a17-helpers';

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

    let expiryPeriodInDaysForAll = Array.prototype.map.call(closers, function(template) {
      return template.dataset['expires'];
    });
    let expiry = expiryPeriodInDaysForAll[0];

    // Now set a cookie so we don't show the notification again for the specified period of time
    if (expiry > 0) {
      ajaxRequest({
        url: '/api/v1/cookie/notification/' + expiry,
        type: 'GET',
      });
    } else {
      ajaxRequest({
        url: '/api/v1/cookie/notification/-3600',
        type: 'GET',
      });
    }
  }

  function _init() {
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
