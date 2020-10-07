@php
    $image = $block->imageAsArray('image', 'desktop');
    $datahub_id = $block->input('objectId');
    $uploaded_manifest = $block->file('upload_manifest_file');
    $final_manifest;
    if ($uploaded_manifest OR $datahub_id) {
        if ($uploaded_manifest) {
            $final_manifest = $uploaded_manifest;
        } else {
            $final_manifest = config('api.base_uri').'/api/v1/artworks/'.$datahub_id.'/manifest.json';
        }
    }
    $caption_title = $block->input('caption_title');
    $caption = $block->input('caption');
@endphp

@if ($final_manifest)
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
            'final_manifest' => $final_manifest,
            'poster' => $image,
            'captionTitle' => getTitleWithFigureNumber($caption_title),
            'caption' => getSubtitleWithFigureNumber($caption, $caption_title),
        ])
    @endcomponent
@endif
