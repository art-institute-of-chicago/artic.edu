import { triggerCustomEvent, setFocusOnTarget, queryStringHandler } from '@area17/a17-helpers';
import { parseHTML, youtubePercentTracking } from '../functions';

const modals = function() {

  const modalActiveClass = 's-modal-active';
  const roadblockActiveClass = 's-roadblock-active';
  const $modal = document.getElementById('modal');
  const $modalPromo = document.getElementById('modal-promo');
  let active = false;

  function _media(e) {
    let embedCode = e.data.embedCode;
    if (embedCode) {
      $modal.classList.add('g-modal--media');
      if (embedCode.indexOf('api.soundcloud.com') > -1) {
        $modal.classList.add('g-modal--media-soundcloud');
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
          setFocusOnTarget($modal);
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
    setFocusOnTarget(document.getElementById('a17'));
    setTimeout(function(){
      $modal.className = 'g-modal';
      $modal.querySelector('[data-modal-content]').innerHTML = '';
    },300);
    active = false;
  }

  function _roadblockOpen() {
    if (document.documentElement.classList.contains(roadblockActiveClass)) {
      active = true;
      triggerCustomEvent(document, 'body:lock', {
        breakpoints: 'all'
      });
      setFocusOnTarget($modalPromo);
      triggerCustomEvent(document, 'focus:trap', {
        element: $modalPromo
      });
    }
  }

  function _closeRoadblock() {
    document.documentElement.classList.remove(roadblockActiveClass);
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

  _roadblockOpen();
};

export default modals;
