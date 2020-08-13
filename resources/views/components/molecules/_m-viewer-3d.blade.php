<div class="m-viewer-3d{{ (isset($guided) && $guided != '') ? ' m-viewer-3d--guided' : '' }}" data-guided="{{ (isset($guided) && $guided != '') ? 'true' : 'false' }}" data-hideannot="{{ (isset($hideannot) && $hideannot != '') ? $hideannot : 'false' }}" data-hideannottitle="{{ (isset($hideannottitle) && $hideannottitle != '') ? $hideannottitle : 'false' }}" data-cc="{{ (isset($cc) && $cc != '') ? $cc : 'false' }}" data-annotations='{{ (isset($annotations)) ? htmlspecialchars($annotations, ENT_QUOTES & ~ENT_COMPAT) : "" }}' data-uid="{{ (isset($uid)) ? $uid : '' }}" data-type="{{ (isset($type)) ? $type : 'modal' }}" data-behavior="viewer3D" data-title="{{ (isset($title)) ? $title : '' }}">
  <iframe tabindex="-1" src="" width="640" height="400" allowFullScreen mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>
  <div class="m-viewer-3d__overlay">
    <button class="m-viewer-3d__explore" type="button">Click to explore</button>
  </div>
  <div class="m-viewer-3d__annotation">
    <div class="m-viewer-3d__annotation__content"></div>
    <button class="m-viewer-3d__annotation__close" tabindex="-1" type="button" aria-label="Close">
      <svg width="16" height="16" viewBox="0 0 16 16">
        <line x1="3" y1="3" x2="13" y2="13" fill="#ffffff" stroke="currentColor" strokeMiterlimit="10" strokeWidth="1.5"></line>
        <line x1="13" y1="3" x2="3" y2="13" fill="#ffffff" stroke="currentColor" strokeMiterlimit="10" strokeWidth="1.5"></line>
      </svg>
    </button>
  </div>
  <div class="m-viewer-3d__hotspots"></div>
  <div class="m-viewer-3d__tools">
    <button class="m-viewer-3d__zoom-in" type="button" aria-label="Zoom in">
      <svg viewBox="0 0 24 24" id="icon--zoom-in--24" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%"><circle cx="10.5" cy="10.5" r="5.5" fill="none" stroke="currentColor" strokeLinejoin="bevel" strokeWidth="1.4"></circle><path fill="none" stroke="currentColor" strokeLinecap="square" strokeLinejoin="bevel" strokeWidth="1.4" d="M14.5 14.5L19 19"></path><path fill="currentColor" d="M10 8h1v5h-1z"></path><path fill="currentColor" d="M13 10v1H8v-1z"></path></svg>
    </button><button class="m-viewer-3d__zoom-out" type="button" aria-label="Zoom out">
      <svg viewBox="0 0 24 24" id="icon--zoom-out--24" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%"><circle cx="10.5" cy="10.5" r="5.5" fill="none" stroke="currentColor" strokeLinejoin="bevel" strokeWidth="1.4"></circle><path fill="none" stroke="currentColor" strokeLinecap="square" strokeLinejoin="bevel" strokeWidth="1.4" d="M14.5 14.5L19 19"></path><path fill="currentColor" d="M13 10v1H8v-1z"></path></svg>
    </button>
    <button class="m-viewer-3d__fullscreen" type="button" aria-label="Fullscreen">
      <svg class="icon-normal" width="32" height="32" viewBox="0 0 32 32">
        <path fill="#ffffff" d="M29.92,2.62a1.15,1.15,0,0,0-.21-.33,1.15,1.15,0,0,0-.33-.21A1,1,0,0,0,29,2H21a1,1,0,0,0,0,2h5.59l-8.3,8.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L28,5.41V11a1,1,0,0,0,2,0V3A1,1,0,0,0,29.92,2.62Z"/>
        <path fill="#ffffff" d="M5.41,4H11a1,1,0,0,0,0-2H3a1,1,0,0,0-.38.08,1.15,1.15,0,0,0-.33.21,1.15,1.15,0,0,0-.21.33A1,1,0,0,0,2,3v8a1,1,0,0,0,2,0V5.41l8.29,8.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"/>
        <path fill="#ffffff" d="M29,20a1,1,0,0,0-1,1v5.59l-8.29-8.3a1,1,0,0,0-1.42,1.42L26.59,28H21a1,1,0,0,0,0,2h8a1,1,0,0,0,.38-.08.9.9,0,0,0,.54-.54A1,1,0,0,0,30,29V21A1,1,0,0,0,29,20Z"/>
        <path fill="#ffffff" d="M12.29,18.29,4,26.59V21a1,1,0,0,0-2,0v8a1,1,0,0,0,.08.38,1.15,1.15,0,0,0,.21.33,1.15,1.15,0,0,0,.33.21A1,1,0,0,0,3,30h8a1,1,0,0,0,0-2H5.41l8.3-8.29a1,1,0,0,0-1.42-1.42Z"/>
      </svg>
      <svg class="icon-active" width="32" height="32" viewBox="0 0 32 32">
        <path fill="#ffffff" d="M10.9,19.4H4c-0.9,0-1.7,0.8-1.7,1.7s0.8,1.7,1.7,1.7h5.1V28c0,0.9,0.8,1.7,1.7,1.7c0.9,0,1.7-0.8,1.7-1.7v-6.9C12.6,20.2,11.8,19.4,10.9,19.4C10.9,19.4,10.9,19.4,10.9,19.4z"/>
        <path fill="#ffffff" d="M28,19.4h-6.9c-0.9,0-1.7,0.8-1.7,1.7c0,0,0,0,0,0V28c0,0.9,0.8,1.7,1.7,1.7s1.7-0.8,1.7-1.7v-5.1H28c0.9,0,1.7-0.8,1.7-1.7S28.9,19.4,28,19.4z"/>
        <path fill="#ffffff" d="M21.1,12.6H28c0.9,0,1.7-0.8,1.7-1.7c0-0.9-0.8-1.7-1.7-1.7h-5.1V4c0-0.9-0.8-1.7-1.7-1.7S19.4,3.1,19.4,4v6.9C19.4,11.8,20.2,12.6,21.1,12.6C21.1,12.6,21.1,12.6,21.1,12.6z"/>
        <path fill="#ffffff" d="M10.9,2.3C9.9,2.3,9.1,3.1,9.1,4c0,0,0,0,0,0v5.1H4c-0.9,0-1.7,0.8-1.7,1.7c0,0.9,0.8,1.7,1.7,1.7h6.9c0.9,0,1.7-0.8,1.7-1.7c0,0,0,0,0,0V4C12.6,3.1,11.8,2.3,10.9,2.3C10.9,2.3,10.9,2.3,10.9,2.3z"/>
      </svg>
    </button>
  </div>
  @if (isset($artwork) and $artwork)
  <a href="/artworks/{{ $artwork->id }}" class="m-viewer-3d__more">Learn more</a>
  @endif
</div>