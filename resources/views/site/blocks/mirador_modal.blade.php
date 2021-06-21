@php
    $image = $block->imageAsArray('image', 'desktop');
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
    $caption_title = $block->input('caption_title');
    $caption = $block->input('caption');
@endphp

@if ($manifest)
    @component('components.molecules._m-media')
        @slot('variation', 'o-blocks__block')
        @slot('item', [
            'type' => 'moduleMirador',
            'media' => [
                'src' => $image['src'],
                'srcset' => $image['src'],
                'width' => $image['width'] ?? 0,
                'height' => $image['height'] ?? 0,
                'alt' => $image['alt'],
                'title' => isset($pageTitle) ? $pageTitle : '',
            ],
            'manifest' => $manifest,
            'default_view' => $default_view,
            'poster' => $image,
            'captionTitle' => $caption_title,
            'caption' => $caption,
        ])
    @endcomponent
@endif
