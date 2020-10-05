@php
  $hash = md5(uniqid(rand(), true));
@endphp

<div id="m-viewer-mirador-{{ $hash }}" data-id="{{ (isset($hash)) ? $hash : '' }}" data-cc="{{ (isset($cc) && $cc != '') ? $cc : 'false' }}" data-type="{{ (isset($type)) ? $type : 'modal' }}" data-behavior="viewerMirador" data-title="{{ (isset($title)) ? $title : '' }}" data-manifest="{{ (isset($manifest)) ? $manifest : 'no manifest available' }}" >

</div>



