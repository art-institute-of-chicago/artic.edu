import { purgeProperties, forEach, getIndex, triggerCustomEvent } from '@area17/a17-helpers';

const headerGallery = function(container) {

  let nodes = {};
  let data = {};
  let activeIndex = 0;
  let maxZoomWindowSize = container.getAttribute('data-headerGallery-maxZoomWindowSize') * 1;

  function _gatherDataFromThumbs() {
    forEach(nodes.thumbButtons, function(index, button) {
      let isActive = (button.getAttribute('disabled'));
      if (isActive) {
        activeIndex = index;
      }
      data[index] = {
        src: button.getAttribute('data-gallery-img-src') || button.nextElementSibling.getAttribute('src') || '',
        srcset: button.getAttribute('data-gallery-img-srcset') || button.nextElementSibling.getAttribute('srcset') || '',
        width: button.getAttribute('data-gallery-img-width') || button.nextElementSibling.getAttribute('width') || '',
        height: button.getAttribute('data-gallery-img-height') || button.nextElementSibling.getAttribute('height') || '',
        credit: button.getAttribute('data-gallery-img-credit') || '',
        creditUrl: button.getAttribute('data-gallery-img-credit-url') || '',
        shareUrl: button.getAttribute('data-gallery-img-share-url') || '',
        shareTitle: button.getAttribute('data-gallery-img-share-title') || '',
        downloadUrl: button.getAttribute('data-gallery-img-download-url') || '',
        downloadName: button.getAttribute('data-gallery-img-download-name') || '',
        active: isActive,
      };
      //
      if (data[index].shareUrl === '' || data[index].shareUrl === '#') {
        data[index].shareUrl = window.location.href;
      }
      if (data[index].shareTitle === '') {
        data[index].shareTitle = document.title;
      }
      if (data[index].downloadUrl === '' || data[index].downloadUrl === '#') {
        data[index].downloadUrl = data[index].srcset.split(' ')[0];
      }
      if (data[index].downloadName === '') {
        data[index].downloadName = 'image';
      }
    });
  }

  function _fixDisplay() {
    let $hero = nodes.hero.querySelector('img');
    if (data[activeIndex].width > data[activeIndex].height) {
      $hero.style.minWidth = '100%';
      $hero.style.minHeight = '';
    } else {
      $hero.style.minWidth = '';
      $hero.style.minHeight = '100%';
    }
  }

  function _update(init) {
    forEach(nodes.thumbButtons, function(index, button) {
      if (index !== activeIndex) {
        data[index].active = false;
        button.removeAttribute('disabled');
      } else {
        data[index].active = true;
        button.setAttribute('disabled','disabled');
      }
    });
    nodes.share.setAttribute('data-share-url', data[activeIndex].shareUrl);
    nodes.share.setAttribute('data-share-title', data[activeIndex].shareTitle);

    if (init) {
      _fixDisplay();
      return;
    }

    container.classList.add('s-updating');

    setTimeout(function(){

      let $hero = nodes.hero.querySelector('img');
      $hero.src = data[activeIndex].src;
      $hero.width = data[activeIndex].width;
      $hero.height = data[activeIndex].height;
      $hero.removeAttribute('srcset');
      _fixDisplay();
      window.requestAnimationFrame(function(){
        $hero.setAttribute('srcset', data[activeIndex].srcset);
      });

      let creditNode;
      creditNode = document.createElement('span');
      if (data[activeIndex].credit) {
        if (data[activeIndex].creditUrl) {
          creditNode = document.createElement('a');
          creditNode.href = data[activeIndex].creditUrl;
        }
        creditNode.innerHTML = data[activeIndex].credit || data[activeIndex].creditUrl;
      } else {
        creditNode.innerHTML = '';
      }
      creditNode.className = 'm-article-header__img-credit f-secondary';
      creditNode.setAttribute('data-gallery-credit','');
      nodes.credit.parentNode.replaceChild(creditNode, nodes.credit);
      nodes.credit = creditNode;

      container.classList.remove('s-updating');
    }, 150)
  }

  function _thumbClick(event) {
    if (event.target.tagName === 'BUTTON') {
      event.preventDefault();
      activeIndex = getIndex(event.target, nodes.thumbButtons);
      _update();
    }
  }

  function _nextClick(event) {
    event.preventDefault();
    activeIndex = (activeIndex < nodes.thumbButtons.length - 1) ? activeIndex + 1 : 0;
    _update();
  }

  function _previousClick(event) {
    event.preventDefault();
    activeIndex = (activeIndex === 0) ? nodes.thumbButtons.length - 1 : activeIndex - 1;
    _update();
  }

  function _downloadClick(event) {
    let a = document.createElement('a');
    document.body.appendChild(a);
    a.download = data[activeIndex].downloadName;
    a.href = data[activeIndex].downloadUrl;
    a.click();
    document.body.removeChild(a);
  }

  function _fullscreen(event) {
    event.preventDefault();
    triggerCustomEvent(document, 'fullScreenImage:open', {
      img: data[activeIndex],
    });
  }

  function _init() {
    //input.addEventListener('input', _updateOutput, false);
    nodes.hero = container.querySelector('[data-gallery-hero]') || false;
    nodes.credit = container.querySelector('[data-gallery-credit]') || false;
    nodes.next = container.querySelector('[data-gallery-next]') || false;
    nodes.previous = container.querySelector('[data-gallery-previous]') || false;
    nodes.fullscreen = container.querySelector('[data-gallery-fullscreen]') || false;
    nodes.download = container.querySelector('[data-gallery-download]') || false;
    nodes.share = container.querySelector('[data-gallery-share]') || false;
    nodes.thumbs = container.querySelector('[data-gallery-thumbs]') || false;
    nodes.thumbButtons = nodes.thumbs.querySelectorAll('button') || false;
    //
    _gatherDataFromThumbs();
    //
    if (nodes.thumbs) {
      nodes.thumbs.addEventListener('click', _thumbClick, false);
    }
    if (nodes.download) {
      nodes.download.addEventListener('click', _downloadClick, false);
    }
    if (nodes.fullscreen) {
      nodes.fullscreen.addEventListener('click', _fullscreen, false);
    }
    //
    if (nodes.next && nodes.previous){
      nodes.next.addEventListener('click', _nextClick, false);
      nodes.previous.addEventListener('click', _previousClick, false);
    }
    //
    _update(true);
  }

  this.destroy = function() {
    // remove specific event handlers
    nodes.thumbs.removeEventListener('click', _thumbClick);
    nodes.download.removeEventListener('click', _downloadClick);
    nodes.fullscreen.removeEventListener('click', _fullscreen);
    //
    if (nodes.next && nodes.previous){
      nodes.next.removeEventListener('click', _nextClick);
      nodes.previous.removeEventListener('click', _previousClick);
    }
    //
    nodes = {};
    data = {};
    // remove properties of this behavior
    purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default headerGallery;
