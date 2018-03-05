import { triggerCustomEvent } from '@area17/a17-helpers';

const setScrollDirection = function() {
  const dE = document.documentElement;

  let lastScrollTop = 0;
  let scrollDirection = false;

  function _init() {
    var sT = document.documentElement.scrollTop || document.body.scrollTop;

    if (sT !== lastScrollTop) {
      triggerCustomEvent(document, 'scroll:active', { 'y': sT });

      if (sT > 400) {
        dE.classList.add('s-allow-top-link');
      } else {
        dE.classList.remove('s-allow-top-link');
      }

      if (sT > lastScrollTop && scrollDirection !== 'down') {
        scrollDirection = 'down';
        dE.classList.remove('s-scroll-direction-up');
        dE.classList.add('s-scroll-direction-down');
        triggerCustomEvent(document, 'scroll:down', { 'y': sT });
      } else if (sT < lastScrollTop && scrollDirection !== 'up') {
        scrollDirection = 'up';
        dE.classList.remove('s-scroll-direction-down');
        dE.classList.add('s-scroll-direction-up');

        triggerCustomEvent(document, 'scroll:up', { 'y': sT });
      }
    }

    lastScrollTop = sT;

    window.requestAnimationFrame(_init);
  }

  _init();
};

export default setScrollDirection;
