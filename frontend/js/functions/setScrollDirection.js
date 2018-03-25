import { triggerCustomEvent } from '@area17/a17-helpers';

const setScrollDirection = function() {
  const dE = document.documentElement;

  let lastScrollTop = 0;
  let scrollDirection = false;
  let hideHeader = false;
  let allowTopLink = false;
  let machineScroll = false;

  function _init() {
    var sT = document.documentElement.scrollTop || document.body.scrollTop;

    if (sT !== lastScrollTop && machineScroll !== true) {
      //triggerCustomEvent(document, 'scroll:active', { 'y': sT });
      if (sT > 0 && !hideHeader){
        dE.classList.add('s-header-hide');
        hideHeader = true;
      } else if (sT <= 0 && hideHeader) {
        dE.classList.remove('s-header-hide');
        hideHeader = false;
      }

      if (sT > 400 && !allowTopLink){
        dE.classList.add('s-allow-top-link');
        allowTopLink = true;
      } else if (sT <= 400 && allowTopLink) {
        dE.classList.remove('s-allow-top-link');
        allowTopLink = false;
      }

      if (sT > lastScrollTop && scrollDirection !== 'down') {
        scrollDirection = 'down';
        dE.classList.remove('s-scroll-direction-up');
        dE.classList.add('s-scroll-direction-down');
        //triggerCustomEvent(document, 'scroll:down', { 'y': sT });
      } else if (sT < lastScrollTop && scrollDirection !== 'up') {
        scrollDirection = 'up';
        dE.classList.remove('s-scroll-direction-down');
        dE.classList.add('s-scroll-direction-up');
        //triggerCustomEvent(document, 'scroll:up', { 'y': sT });
      }
    }

    lastScrollTop = sT;

    window.requestAnimationFrame(_init);
  }

  document.addEventListener('setScrollDirection:machineScroll', function(event){
    machineScroll = event.data.machineScroll;
  });

  _init();
};

export default setScrollDirection;
