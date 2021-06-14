@php
    $datahub_id = $block->input('objectId');
    $uploaded_manifest = $block->file('upload_manifest_file');
    $manifest;
    if ($uploaded_manifest OR $datahub_id) {
        if ($uploaded_manifest) {
            $manifest = $uploaded_manifest;
        } else {
            $manifest = config('api.public_uri').'/api/v1/artworks/'.$datahub_id.'/manifest.json';
        }
    }
    $default_view = $block->input('default_view');
    $size = $block->input('size');

    $captionTitle = $block->input('caption_title');
    $captionText = $block->input('caption');
@endphp

@if ($manifest)
    <div class="m-media m-media--{{ (isset($size)) ? $size : 'm' }} o-blocks__block">
        <div class="m-media__img m-media--mirador-embed" data-behavior="fitText">
            @component('components.molecules._m-viewer-mirador')
                @slot('type', 'standalone')
                @slot('title', isset($pageTitle) ? $pageTitle.' - Inline Mirador' : 'Inline Mirador')
                @slot('manifest', $manifest);
                @slot('defaultView', $default_view);
            @endcomponent
        </div>
        @if ($captionTitle || $captionText)
            <figcaption>
                @if (isset($captionTitle))
                    <div class="f-caption-title">{!! $captionTitle !!}</div><br>
                @endif
                @if (isset($captionText))
                    <div class="f-caption">{!! $captionText !!}</div>
                @endif
            </figcaption>
        @endif
    </div>
@endif
