import { purgeProperties, forEach, triggerCustomEvent } from '@area17/a17-helpers';

const magazineHeader = function(container){

  let currentSlide = 0;
  let links;
  let images;

  let isAutoplaying = true;

  let idleTimer;
  let idleTimeout = 2000;

  let autoTimer;
  let autoTimeout = 5000;

  let activeClass = 'is-slideshow-active';

  function _startIdleTimer() {
    _stopAutoTimer();
    _stopIdleTimer()
    idleTimer = setTimeout(function() {
      _startAutoTimer();
    }, idleTimeout);
  }

  function _stopIdleTimer() {
    if (idleTimer) {
      clearTimeout(idleTimer);
    }
  }

  function _startAutoTimer() {
    _stopAutoTimer();
    isAutoplaying = true;
    autoTimer = setTimeout(function() {
      _tickAutoplay();
    }, autoTimeout);
  }

  function _stopAutoTimer() {
    isAutoplaying = false;
    if (autoTimer) {
      clearTimeout(autoTimer);
    }
  }

  function _tickAutoplay() {
    _advanceCurrentSlide();
    _activateSlide(currentSlide);

    if (isAutoplaying) {
      _startAutoTimer();
    }
  }

  function _activateSlide(index) {
    currentSlide = index;

    links.forEach(link => {
      if (link.classList.contains(activeClass)) {
        link.classList.remove(activeClass);
      }
    });

    if(typeof links[index] !== 'undefined') {
      links[index].classList.add(activeClass);
    }

    images.forEach(image => {
      if (image.classList.contains(activeClass)) {
        image.classList.remove(activeClass);
      }
    });

    if(typeof images[index] !== 'undefined') {
      images[index].classList.add(activeClass);
    }
  }

  function _advanceCurrentSlide() {
    currentSlide++;
    if (currentSlide > links.length - 1) {
      currentSlide = 0;
    }
  }

  function _hoverLink(event) {
    let link = event.target;
    let index = Array.prototype.indexOf.call(links, link);

    _activateSlide(index);
  }

  function _clickPip() {
    // TODO
  }

  function _init() {
    links = container.querySelectorAll('a');
    images = container.querySelectorAll('.m-article-header__img img');

    links.forEach(link => {
      link.addEventListener('mouseover', _stopIdleTimer, false);
      link.addEventListener('mouseover', _hoverLink, false);
      link.addEventListener('mouseout', _startIdleTimer, false);
    });

    _activateSlide(0);
    _startAutoTimer();
  }

  this.destroy = function() {
    links.forEach(link => {
      link.removeEventListener('mouseover', _stopIdleTimer);
      link.removeEventListener('mouseover', _hoverLink);
      link.removeEventListener('mouseout', _startIdleTimer);
    });

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };

};

export default magazineHeader;
