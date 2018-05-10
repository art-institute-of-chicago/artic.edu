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
</div>

<span class="design-grid design-grid--baseline js-hide"></span>
<span class="design-grid design-grid--columns js-hide"></span>

<script>
  var imgBaseline = function(el) {
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

    if( el ){
      el.addEventListener('click', _handleClicks, false);
    }
  };

  document.addEventListener('DOMContentLoaded', function(){
    imgBaseline();
  });
</script>
<!-- END DESIGN GRIDS -->
