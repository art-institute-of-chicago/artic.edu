import { setFocusOnTarget, triggerCustomEvent } from '@area17/a17-helpers';

const displayNotification = function(options) {

  let icon = (options && options.icon) ? options.icon : null;
  let text = (options && options.text) ? options.text : null;
  let type = (options && options.type) ? 'm-notification--'+options.type : null;

  if (!text) {
    return;
  }

  const iconHtml = '<svg class="icon--{{ icon }}" aria-hidden="true"><use xlink:href="#icon--{{ icon }}"></use></svg>';
  const notificationHtml = '<div class="m-notification {{ type }}" data-behavior="notification"><p class="m-notification__text f-secondary">{{ icon }}{{ text }}</p><button class="m-notification__close" data-notification-closer=""><svg class="icon--close" aria-title="Close message"><use xlink:href="#icon--close"></use></svg></button></div>';

  let thisIconHTML = '';
  let thisNotificationHTML = '';

  thisNotificationHTML = notificationHtml.replace(/{{ text }}/ig, text);

  if (type) {
    thisNotificationHTML = thisNotificationHTML.replace(/{{ type }}/ig, type);
  }

  if (icon) {
    thisIconHTML = iconHtml.replace(/{{ icon }}/ig, options.icon);
    thisNotificationHTML = thisNotificationHTML.replace(/{{ icon }}/ig, thisIconHTML);
  }

  let $target = document.getElementById('content');
  $target.insertAdjacentHTML('afterbegin', thisNotificationHTML);
  setTimeout(function(){ setFocusOnTarget($target.firstChild); }, 0)
  triggerCustomEvent(document, 'page:updated');
};

export default displayNotification;
