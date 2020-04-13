import { triggerCustomEvent, setFocusOnTarget, queryStringHandler, cookieHandler, ajaxRequest } from '@area17/a17-helpers';
import { parseHTML, youtubePercentTracking, googleTagManagerDataFromLink } from '../functions';

const roadblock = function() {

  const modalActiveClass = 's-modal-active';
  const roadblockActiveClass = 's-roadblock-active';
  const roadblockDefinedClass = 's-roadblock-defined';
  const $modal = document.getElementById('modal');
  const $modalPromo = document.getElementById('slider-promo');
  let active = false;

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

    // See HomeController::getLightboxGeotarget()
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
    active = true;
    $modalPromo.querySelector('form').addEventListener('submit', _roadblockSubmit, true);
    if (expiryPeriodInDays > 0) {
      cookieHandler.create(cookieName, true, expiryPeriodInDays);
    } else {
      cookieHandler.delete(cookieName);
    }
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

  document.addEventListener('roadblock:close', _closeRoadblock, false);
  window.addEventListener('keyup', _escape, false);

  document.addEventListener('ajaxPageLoad:complete', _roadblockOpenDelayed, false);

  _roadblockOpenDelayed();
};

export default roadblock;
