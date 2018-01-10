import { purgeProperties, forEach, getIndex } from 'a17-helpers';

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
        srcset: button.getAttribute('data-gallery-img-srcset') || button.previousElementSibling.getAttribute('srcset'),
        credit: button.getAttribute('data-gallery-img-credit') || '',
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

  function _update() {
    forEach(nodes.thumbButtons, function(index, button) {
      if (index !== activeIndex) {
        data[index].active = false;
        button.removeAttribute('disabled');
      } else {
        data[index].active = true;
        button.setAttribute('disabled','disabled');
      }
    });
    nodes.hero.querySelector('img').setAttribute('srcset', data[activeIndex].srcset);
    nodes.credit.textContent = data[activeIndex].credit;
    nodes.share.setAttribute('data-share-url', data[activeIndex].shareUrl);
    nodes.share.setAttribute('data-share-title', data[activeIndex].shareTitle);
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
    nodes.thumbs.addEventListener('click', _thumbClick, false);
    nodes.next.addEventListener('click', _nextClick, false);
    nodes.previous.addEventListener('click', _previousClick, false);
    nodes.download.addEventListener('click', _downloadClick, false);
    //
    _update();
  }

  this.destroy = function() {
    nodes = {};
    data = {};
    // remove specific event handlers
    nodes.thumbs.removeEventListener('click', _thumbClick);
    nodes.next.removeEventListener('click', _nextClick);
    nodes.previous.removeEventListener('click', _previousClick);
    nodes.download.removeEventListener('click', _downloadClick);

    // remove properties of this behavior
    purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default headerGallery;
