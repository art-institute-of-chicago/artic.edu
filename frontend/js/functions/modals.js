import { triggerCustomEvent, setFocusOnTarget, queryStringHandler, cookieHandler, ajaxRequest } from '@area17/a17-helpers';
import { parseHTML, youtubePercentTracking, googleTagManagerDataFromLink } from '../functions';

const modals = function() {

  const modalActiveClass = 's-modal-active';
  const roadblockActiveClass = 's-roadblock-active';
  const roadblockDefinedClass = 's-roadblock-defined';
  const $modal = document.getElementById('modal');
  const $modalPromo = document.getElementById('modal-promo');
  let active = false;

  // Do not reset this between AJAX reloads!
  let isLocal = null;

  let isWaitingOnGeotarget = false;

  var cookieName = 'has_seen_lightbox';

  function _media(e) {
    let embedCode = e.data.embedCode;
    if (e.data.module3d) {
      $modal.classList.add('g-modal--module3d');
    } else {
      $modal.classList.remove('g-modal--module3d');
    }
    if (embedCode) {
      $modal.classList.add('g-modal--media');
      if (e.data.subtype) {
        $modal.classList.add('g-modal--media-' + e.data.subtype);
      }
      try {
        let doc = parseHTML(embedCode,'native');
        let iframe = doc.body.firstElementChild;
        let src = iframe.getAttribute('data-embed-src');
        src = (!src) ? iframe.getAttribute('data-src') : src;
        src = (!src) ? iframe.getAttribute('src') : src;
        src = queryStringHandler.updateParameter(src, 'autoplay', '1');
        src = queryStringHandler.updateParameter(src, 'auto_play', '1');
        if (src.indexOf('youtube.com') > -1) {
          src = queryStringHandler.updateParameter(src, 'enablejsapi', '1');
          src = queryStringHandler.updateParameter(src, 'origin', window.location.origin);
        }
        iframe.src = src;
        $modal.querySelector('[data-modal-content]').innerHTML = '';
        $modal.querySelector('[data-modal-content]').appendChild(iframe);
        if (src.indexOf('youtube.com') > -1) {
          youtubePercentTracking(iframe);
        }
      } catch(err) {
        console.log(err);
        $modal.querySelector('[data-modal-content]').innerHTML = embedCode;
      }
      return true;
    } else {
      return false;
    }
  }

  function _openModal(event) {
    _closeModal();

    if (event && event.data.type) {
      if (document.documentElement.classList.contains(roadblockActiveClass)) {
        triggerCustomEvent(document, 'roadblock:close');
      }

      switch (event.data.type) {
        case 'media':
          active = _media(event);
          break;
      }

      if (active) {
        triggerCustomEvent(document, 'body:lock', {
          breakpoints: 'all'
        });
        window.requestAnimationFrame(function(){
          document.documentElement.classList.add(modalActiveClass);
          setTimeout(function(){ setFocusOnTarget($modal); }, 0)
          triggerCustomEvent(document, 'focus:trap', {
            element: $modal
          });
          triggerCustomEvent(document, 'page:updated');
        });
      }
    }
  }

  function _closeModal() {
    if (!active) {
      return;
    }
    triggerCustomEvent(document, 'body:unlock');
    triggerCustomEvent(document, 'focus:untrap');
    document.documentElement.classList.remove(modalActiveClass);
    setTimeout(function(){ setFocusOnTarget(document.getElementById('a17')); }, 0)
    setTimeout(function(){
      $modal.className = 'g-modal';
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
    let $modalTemplates = document.getElementsByClassName('g-modal--promo--template');

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
      let $modalTemplate = document.querySelector('.g-modal--promo--template[data-geotarget="' + geotarget + '"]');

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

    isWaitingOnGeotarget = false;

    var cookie = cookieHandler.read(cookieName) || '';
    var expiryPeriodInDays = parseInt($modalPromo.getAttribute('data-expires')) / 60 / 60 / 24;
    if (cookie && expiryPeriodInDays > 0) {
      return;
    }
    document.documentElement.classList.add(roadblockActiveClass);
    active = true;
    triggerCustomEvent(document, 'body:lock', {
      breakpoints: 'all'
    });
    setTimeout(function(){ setFocusOnTarget($modalPromo); }, 0)
    triggerCustomEvent(document, 'focus:trap', {
      element: $modalPromo
    });
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

  function _resized() {
    // safari isn't repositioning on resize for some reason
    if (active) {
      console.log('resized');
      $modal.style.display = 'none';
      window.requestAnimationFrame(function(){
        $modal.style.display = '';
      });
    }
  }

  function _escape(event) {
    if (document.documentElement.classList.contains(modalActiveClass) && event.keyCode === 27) {
      triggerCustomEvent(document, 'modal:close');
    }
    if (document.documentElement.classList.contains(roadblockActiveClass) && event.keyCode === 27) {
      triggerCustomEvent(document, 'roadblock:close');
    }
  }

  document.addEventListener('modal:close', _closeModal, false);
  document.addEventListener('modal:open', _openModal, false);
  document.addEventListener('roadblock:close', _closeRoadblock, false);
  window.addEventListener('resized', _resized, false);
  window.addEventListener('keyup', _escape, false);

  document.addEventListener('ajaxPageLoad:complete', _roadblockOpenDelayed, false);

  _roadblockOpenDelayed();
};

export default modals;
