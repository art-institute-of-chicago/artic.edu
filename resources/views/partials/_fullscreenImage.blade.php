<div class="o-fullscreen-image" id="fullscreenImage" data-behavior="imageZoomArea">
    <img class="o-fullscreen-image__img">
    <div class="o-fullscreen-image__osd" id="openseadragon"></div>
    <ul class="o-fullscreen-image__img-actions">
      <li>
        @component('components.atoms._btn')
            @slot('variation', 'btn--septenary btn--icon-sq')
            @slot('font', '')
            @slot('icon', 'icon--zoom-in--24')
            @slot('id','osd_zoomInButton')
            @slot('dataAttributes', 'data-fullscreen-zoom-in')
            @slot('ariaLabel', 'Zoom in')
        @endcomponent
      </li>
      <li>
        @component('components.atoms._btn')
            @slot('variation', 'btn--septenary btn--icon-sq')
            @slot('font', '')
            @slot('icon', 'icon--zoom-out--24')
            @slot('id','osd_zoomOutButton')
            @slot('dataAttributes', 'data-fullscreen-zoom-out')
            @slot('ariaLabel', 'Zoom out')
        @endcomponent
      </li>
      <li>
        @component('components.atoms._btn')
            @slot('variation', 'btn--septenary btn--icon-sq')
            @slot('font', '')
            @slot('icon', 'icon--share--24')
            @slot('dataAttributes', 'data-fullscreen-share')
            @slot('behavior', 'sharePage')
            @slot('ariaLabel', 'Share page')
        @endcomponent
      </li>
    </ul>
    @component('components.atoms._btn')
        @slot('variation', 'btn--octonary btn--icon btn--icon-circle-48 o-fullscreen-image__close')
        @slot('font', '')
        @slot('icon', 'icon--close--24')
        @slot('dataAttributes', 'data-fullscreen-close')
        @slot('ariaLabel', 'Close full screen image viewer')
    @endcomponent
</div>
