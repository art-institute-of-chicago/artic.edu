const magazineHeader = function(container){

  let currentSlide = 0;

  let links;
  let images;
  let imagesMobile;

  let pipContainer;
  let pipTemplate;
  let pips;

  let playPauseBtn;

  let isAutoplaying = true;

  let idleTimer;
  let idleTimeout = 2000;

  let autoTimer;
  let autoTimeout = 5000;

  let activeClass = 'is-slideshow-active';

  function _startIdleTimer() {
    _stopAutoTimer();
    _stopIdleTimer();
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
    if (isAutoplaying) {
      autoTimer = setTimeout(function() {
        _tickAutoplay();
      }, autoTimeout);
    }
  }

  function _stopAutoTimer() {
    if (autoTimer) {
      clearTimeout(autoTimer);
    }
  }

  function _tickAutoplay() {
    _advanceCurrentSlide();
    _activateSlide(currentSlide);
    _startAutoTimer();
  }

  function _activateElement(index, elements) {
    elements.forEach(element => {
      if (element.classList.contains(activeClass)) {
        element.classList.remove(activeClass);
      }
    });

    if(typeof elements[index] !== 'undefined') {
      elements[index].classList.add(activeClass);
    }
  }

  function _activateSlide(index) {
    currentSlide = index;

    _activateElement(index, links);
    _activateElement(index, images);
    _activateElement(index, imagesMobile);
    _activateElement(index, pips);
  }

  function _advanceCurrentSlide() {
    currentSlide++;
    if (currentSlide > links.length - 1) {
      currentSlide = 0;
    }
  }

  function _hoverLink(event) {
    let link = event.target.closest('a');
    let index = Array.prototype.indexOf.call(links, link);

    _activateSlide(index);
  }

  function _clickPip(event) {
    let pip = event.target.closest('.m-article-header__pip');
    let index = Array.prototype.indexOf.call(pips, pip);

    _startIdleTimer();
    _activateSlide(index);
  }

  function _clickButton(event) {
    event.preventDefault();
    event.stopPropagation();
    if (isAutoplaying) {
      _pauseAutoplay();
    } else {
      _resumeAutoplay();
    }
  }

  function _pauseAutoplay() {
    isAutoplaying = false;
    playPauseBtn.classList.add('s-paused');
    playPauseBtn.setAttribute('aria-label','Play video');
    _stopAutoTimer();
    _stopIdleTimer();
  }

  function _resumeAutoplay() {
    isAutoplaying = true;
    playPauseBtn.classList.remove('s-paused');
    playPauseBtn.setAttribute('aria-label','Pause video');
    _startAutoTimer();
  }

  function _init() {
    links = container.querySelectorAll('a');
    images = container.querySelectorAll('.m-article-header__img img.img-hero-desktop');
    imagesMobile = container.querySelectorAll('.m-article-header__img img.img-hero-mobile');

    pipContainer = container.querySelector('.m-article-header__pips');
    pipTemplate = container.querySelector('.m-article-header__pip__template').innerHTML;

    playPauseBtn = container.querySelector('.m-article-header__play-pause');

    links.forEach(link => {
      link.addEventListener('mouseover', _stopIdleTimer, false);
      link.addEventListener('mouseover', _hoverLink, false);
      link.addEventListener('mouseout', _startIdleTimer, false);

      pipContainer.insertAdjacentHTML('beforeend', pipTemplate);
    });

    pips = container.querySelectorAll('.m-article-header__pip');

    pips.forEach(pip => {
      pip.addEventListener('click', _clickPip, false);
    });

    playPauseBtn.addEventListener('click', _clickButton, false);

    _activateSlide(0);
    _startAutoTimer();
  }

  this.destroy = function() {
    links.forEach(link => {
      link.removeEventListener('mouseover', _stopIdleTimer);
      link.removeEventListener('mouseover', _hoverLink);
      link.removeEventListener('mouseout', _startIdleTimer);
    });

    pips.forEach(pip => {
      pip.removeEventListener('click', _clickPip);
    });

    playPauseBtn.removeEventListener('click', _clickButton);

    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };

};

export default magazineHeader;
