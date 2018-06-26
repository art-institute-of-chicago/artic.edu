<!-- DESIGN GRIDS -->
<div class="design-grid-toggles" data-env="{{ app()->environment() }}">
  <span class="design-grid-toggle design-grid-toggle--baseline" onClick="document.querySelector('.design-grid--baseline').classList.toggle('js-hide'); this.classList.toggle('js-active');" title="Toggle Baseline Grid">
    <svg enable-background="new 0 0 10 10" version="1.1" viewBox="0 0 10 10" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
      <rect fill="currentColor" width="10" height="1"/>
      <rect fill="currentColor" y="3" width="10" height="1"/>
      <rect fill="currentColor" y="6" width="10" height="1"/>
      <rect fill="currentColor" y="9" width="10" height="1"/>
    </svg>
  </span>

  <span class="design-grid-toggle design-grid-toggle--columns" onClick="document.querySelector('.design-grid--columns').classList.toggle('js-hide'); this.classList.toggle('js-active');" title="Toggle Grid Columns">
    <svg enable-background="new 0 0 10 10" version="1.1" viewBox="0 0 10 10" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
      <rect fill="currentColor" x="0" y="0" width="1" height="18"/>
      <rect fill="currentColor" x="3" y="0" width="1" height="18"/>
      <rect fill="currentColor" x="6" y="0" width="1" height="18"/>
      <rect fill="currentColor" x="9" y="0" width="1" height="18"/>
    </svg>
  </span>

  <span class="design-grid-toggle design-grid-toggle--img" title="Toggle Baseline Images" data-baseline="4">
    <svg enable-background="new 0 0 10 10" version="1.1" viewBox="0 0 10 10" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
      <polygon fill="currentColor" points="8,8 2,8 3.5,3 5.5,6.2 6.5,5.2 "/>
      <circle fill="currentColor" cx="7.2" cy="2.8" r="0.8"/>
      <path fill="currentColor" d="M9,1v8H1V1H9 M10,0H0v10h10V0L10,0z"/>
    </svg>
  </span>

  <span class="design-grid-toggle design-grid-toggle--ajax{{ isset($_COOKIE["A17_ajaxDeactivated"]) ? '' : ' js-active' }}" title="Toggle Ajax Page Loading">
      <svg xmlns="http://www.w3.org/2000/svg" width="221" height="184" viewBox="0 0 221 184"><path fill="currentColor" d="M53.822 47.904L26.669 56.21 3.028 169.937l22.362-7.028c4.792-15.653 23.001-24.917 23.001-24.917l3.194 17.569 17.57-5.749L53.822 47.904zm-23.001 77.628l8.945-41.849 5.431 32.904s-1.278-2.236-14.376 8.945z"/><path fill="currentColor" d="M61.17 168.659s8.945-1.279 9.584-17.89l3.194-107.657 21.723-6.389-5.111 108.616s-1.597 28.432-29.39 35.779v-12.459zM193.744 64.835l17.89-60.058-23.32 6.07-7.986 29.709-13.418-24.278-20.445 6.07 24.598 46.321-15.015 44.404-13.098-89.767-27.153 7.667-23.959 113.726 22.042-7.027c6.389-17.251 22.682-23.321 22.682-23.321l2.874 16.931 35.779-9.903 9.265-29.39 13.098 23.959 19.487-6.389-23.321-44.724zm-73.155 36.099l7.667-42.807 4.792 34.821s-5.751 1.278-12.459 7.986z"/></svg>
      <span>1</span>
  </span>
</div>

<span class="design-grid design-grid--baseline js-hide"></span>
<span class="design-grid design-grid--columns js-hide"></span>

<script>
  var imgBaseline = function() {
    // get baseline - assumes 5px baseline
    var el = document.querySelector('.design-grid-toggle--img');
    var active = false;

    function _handleClicks(e) {
      if( active ){
        document.documentElement.classList.remove('s-image-heights-capped');
        el.classList.remove('js-active');
        active = false;
      }else{
        document.documentElement.classList.add('s-image-heights-capped');
        el.classList.add('js-active');
        active = true;
      }
      e.preventDefault();
    }

    if(el){
      el.addEventListener('click', _handleClicks, false);
    }
  };

  var ajaxToggler = function() {
    var el = document.querySelector('.design-grid-toggle--ajax');
    var modeDisplay = el.querySelector('span');
    var active = !el.classList.contains('js-active');
    var mode = document.documentElement.classList.contains('s-ajax-mode-2') ? 2 : 1;

    function _cookie(name,value,days) {
      if (days) {
          var date = new Date();
          date.setTime(date.getTime()+(days*24*60*60*1000));
          var expires = "; expires="+date.toGMTString();
      }
      else var expires = "";
      document.cookie = name+"="+value+expires+"; path=/";
    }

    function _readCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    }

    function _deactivate() {
        A17.ajaxLinksActive = false;
        el.classList.remove('js-active');
        _cookie('A17_ajaxDeactivated',true,1);
        active = false;
        mode = 1;
        modeDisplay.textContent = mode;
        document.documentElement.classList.remove('s-ajax-mode-2');
    }

    function _activate() {
        A17.ajaxLinksActive = true;
        el.classList.add('js-active');
        _cookie('A17_ajaxDeactivated','',-1);
        active = true;
    }

    function _handleClicks(e) {
      if(active){
        if (mode === 1) {
            mode = 2;
            modeDisplay.textContent = mode;
            document.documentElement.classList.add('s-ajax-mode-2');
        } else {
            _deactivate();
        }
      }else{
        _activate();
      }
      e.preventDefault();
    }

    if (_readCookie('A17_ajaxDeactivated')) {
        active = false;
    }

    if (!active) {
        _deactivate();
    }

    modeDisplay.textContent = mode;
    el.addEventListener('click', _handleClicks, false);
  }

  document.addEventListener('DOMContentLoaded', function(){
    imgBaseline();
    ajaxToggler();
  });

  document.addEventListener('page:updated', function(){
    imgBaseline();
    ajaxToggler();
  });
</script>
<!-- END DESIGN GRIDS -->
