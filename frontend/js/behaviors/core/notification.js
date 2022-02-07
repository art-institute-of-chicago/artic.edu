import { forEach, cookieHandler, triggerCustomEvent } from '@area17/a17-helpers';

const notification = function(container) {

  let closers = container.querySelectorAll('[data-notification-closer]');
  let cookieName = 'has_seen_notification';
  let cookieValue = container.getAttribute('data-notification-hash'); // Null if absent

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
    let expiryPeriodInDays = expiryPeriodInDaysForAll[0];

    // Now set a cookie so we don't show the notification again for the specified period of time
    if (cookieValue) {
      if (expiryPeriodInDays > 0) {
        cookieHandler.create(cookieName, cookieValue, expiryPeriodInDays);
      } else {
        cookieHandler.create(cookieName, cookieValue, -3600);
      }
    }
  }

  function _init() {
    var cookie = cookieHandler.read(cookieName) || '';

    // Cookie values are always stored as strings
    if (cookieValue && cookie === cookieValue) {
      container.parentNode.removeChild(container);
      return;
    } else {
      container.classList.add('m-notification--header-loaded');
      triggerCustomEvent(document, 'notification:confirmed', {});
    }

    forEach(closers, function(index, closer) {
      closer.addEventListener('click', _handleClicks, false);
    });
  }

  this.destroy = function() {
    // Remove specific event handlers
    forEach(closers, function(index, closer) {
      closer.removeEventListener('click', _handleClicks);
    });
    closers = undefined;
    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default notification;
