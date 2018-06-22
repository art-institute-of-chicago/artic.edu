import { purgeProperties, ajaxRequest, objectifyForm, triggerCustomEvent } from '@area17/a17-helpers';

const newsletter = function(container) {

  let msg = null;

  function _disable() {
    container.classList.add('s-loading');
    container.setAttribute('disabled', 'disabled');
  }

  function _enable() {
    container.classList.remove('s-loading');
    container.removeAttribute('disabled');
  }

  function _removePreviousState() {
    if (msg) {
      container.removeChild(msg);
      msg = null;
    }
    container.classList.remove('s-success');
    container.classList.remove('s-error');
  }

  function _updateState(type, message) {
    _removePreviousState();
    msg = document.createElement('em');
    msg.className = 'm-aside-newsletter__msg f-buttons';
    if (type === 'success') {
      msg.className += ' m-aside-newsletter__msg--success';
      msg.textContent = message || 'Successfully signed up to the newsletter';
      container.classList.add('s-success');
    } else if (type === 'error') {
      msg.className += ' m-aside-newsletter__msg--error';
      msg.textContent = message || 'Error signing up to the newsletter';
      container.classList.add('s-error');
    }
    container.appendChild(msg);
  }

  function _handleSubmit(event) {
    event.preventDefault();
    event.stopPropagation();
    _removePreviousState();
    _disable();
    let formData = objectifyForm(container);
    ajaxRequest({
      url: container.action || '/subscribe',
      type: 'POST',
      requestHeaders: [
        {
          header: 'Content-Type',
          value: 'application/x-www-form-urlencoded; charset=UTF-8'
        },
        {
          header: 'X-CSRF-Token',
          value: document.querySelector('meta[name=csrf-token]').getAttribute('content') || ''
        }
      ],
      data: formData,
      onSuccess: function(data){
        try {
          data = JSON.parse(data);
          container.classList.remove('s-loading');
          container.setAttribute('disabled', 'disabled');
          container.querySelector('input[name=email]').value = '';
          _updateState('success', data.message || data.email);
          // tell GTM
          triggerCustomEvent(document, 'gtm:push', {
            'event': 'sign-up',
            'eventCategory': 'subscribe',
            'email': formData.email
          });
        } catch (err) {
          console.error('Error submitting newsletter sign up (a)');
          console.log(err,data);
          _updateState('error');
        }
        _enable();
      },
      onError: function(data){
        try {
          data = JSON.parse(data);
          _updateState('error', data.message || data.email);
        } catch(err) {
          console.error('Error submitting newsletter sign up (b)');
          console.log(data, err);
          _updateState('error');
        }
        _enable();
      }
    });
  }

  function _init() {
    container.addEventListener('submit', _handleSubmit, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    container.removeEventListener('submit', _handleSubmit);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default newsletter;
