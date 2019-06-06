import { purgeProperties, forEach, getIndex, triggerCustomEvent } from '@area17/a17-helpers';

const headerGallery = function(container) {

  let nodes = {};
  let data = {};
  let activeIndex = 0;

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
        alt: button.getAttribute('data-gallery-img-alt') || button.nextElementSibling.getAttribute('alt') || '',
        creditUrl: button.getAttribute('data-gallery-img-credit-url') || '',
        shareUrl: button.getAttribute('data-gallery-img-share-url') || '',
        shareTitle: button.getAttribute('data-gallery-img-share-title') || '',
        downloadUrl: button.getAttribute('data-gallery-img-download-url') || '',
        downloadName: button.getAttribute('data-gallery-img-download-name') || '',
        iiifId: button.getAttribute('data-gallery-img-iiifId') || button.nextElementSibling.getAttribute('data-gallery-img-iiifId') || null,
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
    let $image = nodes.hero.querySelector('img');

    let heroAspect = nodes.hero.offsetWidth / nodes.hero.offsetHeight;
    let imageAspect = $image.offsetWidth / $image.offsetHeight;
    let diffAspect = imageAspect - heroAspect;

    if (diffAspect > 0) {
      $image.style.width = nodes.hero.offsetWidth + 'px';
      $image.style.height = null;
    } else {
      $image.style.height = nodes.hero.offsetHeight + 'px';
      $image.style.width = null;
    }
  }

  function _loaded() {
    let $hero = nodes.hero.querySelector('img');
    $hero.removeEventListener('load', _loaded);
    $hero.setAttribute('srcset', data[activeIndex].srcset);
    container.classList.remove('s-updating');
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
    forEach(nodes.share, function(index, node) {
      node.setAttribute('data-share-url', data[activeIndex].shareUrl);
      node.setAttribute('data-share-title', data[activeIndex].shareTitle);
    });

    if (init) {
      return;
    }

    container.classList.add('s-updating');

    setTimeout(function(){

      let $hero = nodes.hero.querySelector('img');
      $hero.removeAttribute('srcset');
      $hero.removeAttribute('data-srcset');

      $hero.src = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
      $hero.addEventListener('load', _loaded, false);
      $hero.src = data[activeIndex].src;

      $hero.width = data[activeIndex].width;
      $hero.height = data[activeIndex].height;
      $hero.alt = data[activeIndex].alt;

      // WEB-1028: Disabling dimension limiting to prevent stretching
      // _fixDisplay();

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
      creditNode.className = 'm-article-header__img-credit f-caption';
      creditNode.setAttribute('data-gallery-credit','');
      nodes.credit.parentNode.replaceChild(creditNode, nodes.credit);
      nodes.credit = creditNode;
    }, 150)
  }

  function _thumbClick(event) {
    if (event.target.tagName === 'BUTTON') {
      event.preventDefault();
      activeIndex = getIndex(event.target, nodes.thumbButtons);
      _update();
      triggerCustomEvent(document, 'gtm:push', {
        'event': 'artwork-alternate-image',
        'eventCategory': 'in-page',
      });
    }
  }

  // function _nextClick(event) {
  //   event.preventDefault();
  //   activeIndex = (activeIndex < nodes.thumbButtons.length - 1) ? activeIndex + 1 : 0;
  //   _update();
  //   triggerCustomEvent(document, 'gtm:push', {
  //     'event': 'artwork-alternate-image',
  //     'eventCategory': 'in-page',
  //   );
  // }

  // function _previousClick(event) {
  //   event.preventDefault();
  //   activeIndex = (activeIndex === 0) ? nodes.thumbButtons.length - 1 : activeIndex - 1;
  //   _update();
  //   triggerCustomEvent(document, 'gtm:push', {
  //     'event': 'artwork-alternate-image',
  //     'eventCategory': 'in-page',
  //   );
  // }

  function _downloadClick(event) {
    let a = document.createElement('a');
    document.body.appendChild(a);
    a.download = data[activeIndex].downloadName;
    a.href = data[activeIndex].downloadUrl;
    a.setAttribute('target','_blank');
    a.click();
    document.body.removeChild(a);
    triggerCustomEvent(document, 'gtm:push', {
      'event': 'artwork-download',
      'eventCategory': 'in-page',
    });
  }

  function _fullscreen(event) {
    event.preventDefault();
    triggerCustomEvent(document, 'fullScreenImage:open', {
      img: data[activeIndex],
    });
  }

  function _resized() {
    _update(true);
  }

  function _init() {
    nodes.hero = container.querySelector('[data-gallery-hero]') || false;
    nodes.credit = container.querySelector('[data-gallery-credit]') || false;
    //nodes.next = container.querySelectorAll('[data-gallery-next]') || false;
    //nodes.previous = container.querySelectorAll('[data-gallery-previous]') || false;
    nodes.fullscreen = container.querySelectorAll('[data-gallery-fullscreen]') || false;
    nodes.download = container.querySelectorAll('[data-gallery-download]') || false;
    nodes.share = container.querySelectorAll('[data-gallery-share]') || false;
    nodes.thumbs = container.querySelector('[data-gallery-thumbs]') || false;
    nodes.thumbButtons = nodes.thumbs.querySelectorAll('button') || false;
    //
    _gatherDataFromThumbs();
    //
    if (nodes.thumbs) {
      nodes.thumbs.addEventListener('click', _thumbClick, false);
    }
    if (nodes.download) {
      forEach(nodes.download, function(index, node) {
        node.addEventListener('click', _downloadClick, false);
      });
    }
    if (nodes.fullscreen) {
      forEach(nodes.fullscreen, function(index, node) {
        node.addEventListener('click', _fullscreen, false);
      });
    }
    //
    // if (nodes.next && nodes.previous){
    //   forEach(nodes.next, function(index, node) {
    //     node.addEventListener('click', _nextClick, false);
    //   });
    //   forEach(nodes.previous, function(index, node) {
    //     node.addEventListener('click', _previousClick, false);
    //   });
    // }
    //
    document.addEventListener('resized', _resized, false);
    _update(true);
  }

  this.destroy = function() {
    // remove specific event handlers
    nodes.thumbs.removeEventListener('click', _thumbClick);
    nodes.download.removeEventListener('click', _downloadClick);
    nodes.fullscreen.removeEventListener('click', _fullscreen);
    //
    // if (nodes.next && nodes.previous){
    //   nodes.next.removeEventListener('click', _nextClick);
    //   nodes.previous.removeEventListener('click', _previousClick);
    // }
    document.removeEventListener('resized', _resized);
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
