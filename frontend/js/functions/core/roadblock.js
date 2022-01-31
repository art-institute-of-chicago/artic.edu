import { triggerCustomEvent, setFocusOnTarget, objectifyForm, cookieHandler, ajaxRequest } from '@area17/a17-helpers';
import { googleTagManagerDataFromLink } from '../core';

const roadblock = function(container) {

  const modalActiveClass = 's-modal-active';
  const roadblockActiveClass = 's-roadblock-active';
  const roadblockDefinedClass = 's-roadblock-defined';
  const $modal = document.getElementById('modal');
  const $modalPromo = document.getElementById('slider-promo');
  let active = false;

  let isNewsletter = false;
  let $msg = null;

  // Do not reset this between AJAX reloads!
  let isLocal = null;
  let isWaitingOnGeotarget = false;
  var cookieName = 'has_seen_lightbox';

  function _closeModal() {
    if (!active) {
      return;
    }
    triggerCustomEvent(document, 'body:unlock');
    triggerCustomEvent(document, 'focus:untrap');
    document.documentElement.classList.remove(modalActiveClass);
    setTimeout(function(){ setFocusOnTarget(document.getElementById('a17')); }, 0)
    setTimeout(function(){
      $modal.className = 'g-slider';
      $modal.querySelector('[data-modal-content]').innerHTML = '';
    },300);
    active = false;
  }

  function _roadblockOpenDelayed() {
    // We do some duplicate checks in this function to reduce geotarget calls
    if (!document.documentElement.classList.contains(roadblockDefinedClass)) {
      return;
    }

    // Figure out which modal template to use and copy it to $modalPromo
    let $modalTemplates = document.getElementsByClassName('g-slider--promo--template');

    if ($modalTemplates.length < 1) {
      return;
    }

    // Check if the data-expires of all templates is equal, and if there's a cookie already
    let cookie = cookieHandler.read(cookieName) || '';
    let expiryPeriodInDaysForAll = Array.prototype.map.call($modalTemplates, function(template) {
      return template.dataset['expires'];
    });
    let isExpirySameForAll = expiryPeriodInDaysForAll.every(function(val, i, arr) {
      return val === arr[0];
    });

    if (cookie && isExpirySameForAll && expiryPeriodInDaysForAll[0] > 0) {
      return;
    }

    let geotargets = Array.prototype.map.call($modalTemplates, function(template) {
      return template.dataset['geotarget'];
    });

    isWaitingOnGeotarget = false;

    // @see HomeController::getLightboxGeotarget()
    if (geotargets.includes('all')) {
      _swapRoadblock('all');
    } else {
      if (isLocal !== null) {
        _swapRoadblock(isLocal ? 'local' : 'not-local');
      } else {
        isWaitingOnGeotarget = true;
        ajaxRequest({
          url: '/api/v1/geotarget',
          type: 'GET',
          onSuccess: function(data) {
            isLocal = JSON.parse(data)['is_local'];
            isLocal = isLocal === null ? true : isLocal;
            _swapRoadblock(isLocal ? 'local' : 'not-local');
            isWaitingOnGeotarget = false;
          },
          onError: function(data) {
            _swapRoadblock('local');
            isWaitingOnGeotarget = false;
          }
        });
      }
    }

    setTimeout(_roadblockOpen, 3000);
  }

  function _swapRoadblock(geotarget) {
      let $modalTemplate = document.querySelector('.g-slider--promo--template[data-geotarget="' + geotarget + '"]');

      if (!$modalTemplate) {
        switch (geotarget) {
          case 'local':
            _swapRoadblock('all');
            break;
          case 'all':
            document.documentElement.classList.remove(roadblockDefinedClass);
            break;
        }
        return;
      }

      $modalPromo.dataset['expires'] = $modalTemplate.dataset['expires'];
      $modalPromo.innerHTML = $modalTemplate.innerHTML;

      // Reinitialize behaviors for close button, etc.
      triggerCustomEvent($modalPromo, 'content:updated', {
        el: $modalPromo,
      });

      document.documentElement.classList.add(roadblockDefinedClass);
  }

  function _roadblockOpen(hasGeotargetTimedOut) {
    if (!document.documentElement.classList.contains(roadblockDefinedClass)) {
      return;
    }

    if (isWaitingOnGeotarget) {
      if (!hasGeotargetTimedOut) {
        setTimeout(function() {
          _roadblockOpen(true);
        }, 2000);
        return;
      } else {
        _swapRoadblock('local');
      }
    }

    // WEB-1499: Do not show skrim if the lightbox is empty
    if ($modalPromo.innerHTML === '') {
      return;
    }

    isWaitingOnGeotarget = false;

    var cookie = cookieHandler.read(cookieName) || '';
    var expiryPeriodInDays = parseInt($modalPromo.getAttribute('data-expires')) / 60 / 60 / 24;
    if (cookie && expiryPeriodInDays > 0) {
      return;
    }
    document.documentElement.classList.add(roadblockActiveClass);

    isNewsletter = $modalPromo.querySelector('.g-slider--promo__variation--newsletter') !== null;
    $msg = null

    active = true;

    $modalPromo.querySelector('form').addEventListener('submit', _roadblockSubmit, true);
    if (expiryPeriodInDays > 0) {
      cookieHandler.create(cookieName, true, expiryPeriodInDays);
    } else {
      cookieHandler.delete(cookieName);
    }
    var $modalPromoButton = $modalPromo.getElementsByTagName('button')[0];
    setTimeout(function() {
      $modalPromoButton.classList.remove('btn--secondary');
      $modalPromoButton.classList.add('btn--animating');
      setTimeout(function() {
        $modalPromoButton.classList.remove('btn--animating');
      }, 900);
    }, 1200);
  }

  function _closeRoadblock() {
    document.documentElement.classList.remove(roadblockActiveClass);
    _closeModal();
  }

  function _roadblockSubmit(event) {
    let firstnameElement = document.getElementById('edit-submitted-first-name');
    let lastnameElement = document.getElementById('edit-submitted-last-name');
    let emailElement = document.getElementById('edit-submitted-mail');
    let tlcsourceElement = document.getElementById('edit-submitted-tlcsource');

    // Sidebar into newsletter behavior
    if (isNewsletter) {
      return _newsletterSubmit(event);
    }

    // We pass values from lightbox to form via a cookie
    let cookieValue = encodeURIComponent(JSON.stringify({
      firstname: firstnameElement ? firstnameElement.value : null,
      lastname: lastnameElement ? lastnameElement.value : null,
      email: emailElement ? emailElement.value : null,
      tlcsource: tlcsourceElement ? tlcsourceElement.value : null,
    }));

    // Ensure this cookie works across subdomains
    cookieValue += ';domain=.artic.edu';

    cookieHandler.create('tlc_lb_signup', cookieValue, 30);

    let googleTagManagerObject = googleTagManagerDataFromLink(event.target);
    if (googleTagManagerObject) {
      triggerCustomEvent(document, 'gtm:push', googleTagManagerObject);
    }

    triggerCustomEvent(document, 'roadblock:close');
  }

  function _escape(event) {
    if (document.documentElement.classList.contains(roadblockActiveClass) && event.keyCode === 27) {
      triggerCustomEvent(document, 'roadblock:close');
    }
  }

  // Adapted from newsletter behavior
  function _newsletterSubmit(event) {
    let $form = $modalPromo.querySelector('form');

    event.preventDefault();
    event.stopPropagation();
    _removePreviousState();
    _disable();
    let formData = objectifyForm($form);

    ajaxRequest({
      url: $form.action || '/subscribe',
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
          $form.classList.remove('s-loading');
          $form.setAttribute('disabled', 'disabled');
          $form.querySelector('input[name=email]').value = '';
          _updateState('success', data.message || data.email);
          // Tell GTM
          triggerCustomEvent(document, 'gtm:push', {
            'event': 'sign-up',
            'eventCategory': 'subscribe',
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

  // Adapted from newsletter behavior
  function _disable() {
    let $btn = $modalPromo.querySelector('button');
    $btn.classList.add('s-loading');
    $btn.setAttribute('disabled', 'disabled');
  }

  // Adapted from newsletter behavior
  function _enable() {
    let $btn = $modalPromo.querySelector('button');
    $btn.classList.remove('s-loading');
    $btn.removeAttribute('disabled');
  }

  // Adapted from newsletter behavior
  function _removePreviousState() {
    $modalPromo.classList.remove('g-slider--msg-active');
    let $container = $modalPromo.querySelector('.g-slider--promo__variation--newsletter');
    let $form = $modalPromo.querySelector('form');
    if ($msg) {
      $container.removeChild($msg);
      $msg = null;
    }
    $form.classList.remove('s-success');
    $form.classList.remove('s-error');
  }

  // Adapted from newsletter behavior
  function _updateState(type, message) {
    let $container = $modalPromo.querySelector('.g-slider--promo__variation--newsletter');

    _removePreviousState();

    let $msgContent = document.createElement('div');
    $msgContent.className = 'g-slider__msg__content';

    $msg = document.createElement('div');
    $msg.className = 'g-slider__msg f-buttons';

    if (type === 'success') {
      $msg.className += ' g-slider__msg--success';
      $msgContent.textContent = message || 'Successfully signed up to the newsletter';
      $container.classList.add('s-success');
    } else if (type === 'error') {
      $msg.className += ' g-slider__msg--error';
      $msgContent.textContent = message || 'Error signing up to the newsletter';
      $container.classList.add('s-error');
    }

    $modalPromo.classList.add('g-slider--msg-active');

    $msg.append($msgContent);
    $container.prepend($msg);
  }

  document.addEventListener('roadblock:close', _closeRoadblock, false);
  window.addEventListener('keyup', _escape, false);

  document.addEventListener('ajaxPageLoad:complete', _roadblockOpenDelayed, false);

  _roadblockOpenDelayed();
};

export default roadblock;
