import { triggerCustomEvent, setFocusOnTarget, queryStringHandler, cookieHandler } from '@area17/a17-helpers';
import { parseHTML, youtubePercentTracking } from '../functions';

const modals = function() {

  const modalActiveClass = 's-modal-active';
  const roadblockActiveClass = 's-roadblock-active';
  const roadblockDefinedClass = 's-roadblock-defined';
  const $modal = document.getElementById('modal');
  const $modalPromo = document.getElementById('modal-promo');
  let active = false;

  var cookieName = 'has_seen_lightbox';
  var cookie = cookieHandler.read(cookieName) || '';

  function _media(e) {
    let embedCode = e.data.embedCode;
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
    setTimeout(_roadblockOpen, 3000);
  }

  function _roadblockOpen() {
    if (!document.documentElement.classList.contains(roadblockDefinedClass)) {
      return;
    }
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
    $modalPromo.addEventListener('submit', _roadblockSubmit, true);
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
    // We pass values from lightbox to form via a cookie
    var cookieValue = encodeURIComponent(JSON.stringify({
      firstname: document.getElementById('edit-submitted-first-name').value,
      lastname: document.getElementById('edit-submitted-last-name').value,
      email: document.getElementById('edit-submitted-mail').value,
      tlcsource: document.getElementById('edit-submitted-tlcsource').value,
    }));

    // Ensure this cookie works across subdomains
    cookieValue += ';domain=.artic.edu';

    cookieHandler.create('tlc_lb_signup', cookieValue, 30);
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
