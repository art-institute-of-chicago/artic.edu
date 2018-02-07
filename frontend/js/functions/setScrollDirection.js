const setScrollDirection = function() {
  const dE = document.documentElement;

  let lastScrollTop = 0;
  let scrollDirection = false;

  function _init() {
    var sT = document.documentElement.scrollTop || document.body.scrollTop;

    if (sT !== lastScrollTop) {
      if (sT > lastScrollTop && scrollDirection !== 'down') {
        scrollDirection = 'down';
        dE.classList.remove('s-scroll-direction-up');
        dE.classList.add('s-scroll-direction-down');
      } else if (sT < lastScrollTop && scrollDirection !== 'up') {
        scrollDirection = 'up';
        dE.classList.remove('s-scroll-direction-down');
        dE.classList.add('s-scroll-direction-up');
      }
    }

    lastScrollTop = sT;

    window.requestAnimationFrame(_init);
  }

  _init();
};

export default setScrollDirection;
