@php
  $hash = md5(uniqid(rand(), true));
@endphp

<div id="m-viewer-virtualtour-{{ $hash }}" class="m-viewer-virtualtour" data-id="{{ (isset($hash)) ? $hash : '' }}" data-cc="{{ (isset($cc) && $cc != '') ? $cc : 'false' }}" data-behavior="viewerVirtualTour" data-vtourxml="{{ (isset($vtourxml)) ? $vtourxml : 'no tour available' }}">
</div>
