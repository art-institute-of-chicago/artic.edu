const loadProgressBar = function() {

  var $bar = null;
  var $progress = null;
  var currentPercent = 0;
  var timeout;

  function randomTime() {
    return Math.random() * 2000;
  }

  function progress() {
    currentPercent += (90 - currentPercent) * 0.2;
    $progress.style.width = currentPercent + '%';
    timeout = setTimeout(progress,randomTime());
  }

  function removeProgressBar() {
    document.body.removeChild($bar);
    $bar = null;
    $progress = null;
    currentPercent = 0;
  }

  function showLoader() {
    if ($bar) {
      removeProgressBar();
    }
    $bar = document.createElement('span');
    $bar.className = 'progress-bar';
    $progress = document.createElement('span');
    $progress.style.opacity = 0;
    $bar.appendChild($progress);
     document.body.appendChild($bar);
    setTimeout(function(){
      $progress.style.opacity = 1;
    });
    timeout = setTimeout(function() {
      currentPercent += (90 - currentPercent) * 0.4;
      $progress.style.width = currentPercent + '%';
      progress();
    },250);
  }

  function loadComplete() {
    try {
      clearTimeout(timeout);
    } catch(err) {}
    $progress.style.width = '100%';
    setTimeout(removeProgressBar,250);
  }

  function loadError() {
    try {
      clearTimeout(timeout);
    } catch(err) {}
    $progress.style.width = '0%';
    setTimeout(removeProgressBar,250);
  }

  document.addEventListener('loader:start',showLoader);
  document.addEventListener('loader:complete',loadComplete);
  document.addEventListener('loader:error',loadComplete);
};

export default loadProgressBar;
