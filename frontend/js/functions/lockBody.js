const lockBody = function() {

  let lockBodyScrollTop = 0;
  let locked = false;

  function _lock(event) {
    if (event.data.breakpoints === 'all') {
      event.data.breakpoints = 'xsmall small medium large xlarge';
    }
    if (event.data.breakpoints.indexOf(A17.currentMediaQuery) > -1) {
      locked = true;
      lockBodyScrollTop = window.pageYOffset;
      document.documentElement.classList.add('s-body-locked');
      document.getElementById('a17').style.top = (lockBodyScrollTop * -1) + 'px';
      let vpH = window.innerHeight.toString();
      document.documentElement.style.height = vpH.toString() + 'px';
      document.body.style.height = vpH.toString() + 'px';
    }
  }

  function _unlock() {
    if (locked) {
      locked = false;
      document.documentElement.classList.remove('s-body-locked');
      document.getElementById('a17').style.top = '';
      document.documentElement.style.height = '';
      document.body.style.height = '';
      window.scrollTo(0, lockBodyScrollTop);
      setTimeout(function(){
        window.scrollTo(0, lockBodyScrollTop);
        lockBodyScrollTop = 0;
      }, 1);
    }
  }

  document.addEventListener('body:lock', _lock, false);
  document.addEventListener('body:unlock', _unlock, false);
};

export default lockBody;
