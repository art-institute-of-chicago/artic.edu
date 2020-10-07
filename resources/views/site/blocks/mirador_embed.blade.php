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
    $caption_title = $block->input('caption_title');
    $caption = $block->input('caption');
    $size = $block->input('size');
@endphp

@if ($manifest)
    <div class="m-media m-media--{{ (isset($size)) ? $size : 'm' }} o-blocks__block">
        <div class="m-media__img m-media--mirador-embed" data-behavior="fitText">
            @component('components.molecules._m-viewer-mirador')
                @slot('type', 'standalone')
                @slot('title', isset($pageTitle) ? $pageTitle.' - Inline Mirador' : 'Inline Mirador')
                @slot('manifest', $manifest);
            @endcomponent
        </div>
        @if ($caption_title || $caption)
            <figcaption>
                @if (isset($caption_title))
                    <div class="f-caption-title">{!! $caption_title !!}</div><br>
                @endif
                @if (isset($caption))
                    <div class="f-caption">{!! $caption !!}</div>
                @endif
            </figcaption>
        @endif
    </div>
@endif
