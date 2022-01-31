import { triggerCustomEvent, setFocusOnTarget, queryStringHandler } from '@area17/a17-helpers';
import { parseHTML, youtubePercentTracking } from '../core';

const modals = function() {

  const modalActiveClass = 's-modal-active';
  const $modal = document.getElementById('modal');
  const $modalPromo = document.getElementById('modal-promo');
  let active = false;

  function _media(e) {
    let embedCode = e.data.embedCode;
    if (e.data.restricted) {
      $modal.classList.add('g-modal--restricted');
    } else {
      $modal.classList.remove('g-modal--restricted');
    }
    if (e.data.module3d) {
      $modal.classList.add('g-modal--module3d');
    } else {
      $modal.classList.remove('g-modal--module3d');
    }
    if (e.data.module360) {
      $modal.classList.add('g-modal--module360');
    } else {
      $modal.classList.remove('g-modal--module360');
    }
    if (e.data.moduleMirador) {
      $modal.classList.add('g-modal--moduleMirador');
    } else {
      $modal.classList.remove('g-modal--moduleMirador');
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

  function _resized() {
    // Safari isn't repositioning on resize for some reason
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
  }

  document.addEventListener('modal:close', _closeModal, false);
  document.addEventListener('modal:open', _openModal, false);
  window.addEventListener('resized', _resized, false);
  window.addEventListener('keyup', _escape, false);
};

export default modals;
