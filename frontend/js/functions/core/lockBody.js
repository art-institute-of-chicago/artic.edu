import { triggerCustomEvent } from '@area17/a17-helpers';

const lockBody = function() {

  let lockBodyScrollTop = 0;
  let locked = false;

  function _lock(event) {
    if (event.data.breakpoints === 'all') {
      event.data.breakpoints = 'xsmall small medium large xlarge';
    }
    if (event.data.breakpoints.indexOf(A17.currentMediaQuery) > -1) {
      triggerCustomEvent(document, 'setScrollDirection:machineScroll', {
        'machineScroll': true
      });
      locked = true;
      lockBodyScrollTop = window.pageYOffset;
      document.getElementById('a17').style.top = (lockBodyScrollTop * -1) + 'px';
      window.requestAnimationFrame(function(){
        document.documentElement.classList.add('s-body-locked');
      });
    }
  }

  function _unlock() {
    if (locked) {
      locked = false;
      document.getElementById('a17').style.top = '';
      document.documentElement.classList.remove('s-body-locked');
      window.scrollTo(0, lockBodyScrollTop);
      setTimeout(function(){
        window.scrollTo(0, lockBodyScrollTop);
        lockBodyScrollTop = 0;
        triggerCustomEvent(document, 'setScrollDirection:machineScroll', {
          'machineScroll': false
        });
      }, 1);
    }
  }

  document.addEventListener('body:lock', _lock, false);
  document.addEventListener('body:unlock', _unlock, false);
};

export default lockBody;
