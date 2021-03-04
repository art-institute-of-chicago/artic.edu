@php
  $hash = md5(uniqid(rand(), true));
@endphp

<div id="m-viewer-mirador-{{ $hash }}" class="{{ (isset($type) && $type=='mirador-kiosk') ? $type : 'm-viewer-mirador' }}" data-id="{{ (isset($hash)) ? $hash : '' }}" data-cc="{{ (isset($cc) && $cc != '') ? $cc : 'false' }}" data-type="{{ (isset($type)) ? $type : 'modal' }}" data-behavior="viewerMirador" data-title="{{ (isset($title)) ? $title : '' }}" data-manifest="{{ (isset($manifest)) ? $manifest : 'no manifest available' }}" data-view="{{ (isset($defaultView)) ? $defaultView : 'single' }}" >
</div>
