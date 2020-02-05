@php
    $embed_code = $block->input('embed_code');
    $embed_height =$block->input('embed_height');
@endphp

@if ($embed_code)
    @component('components.molecules._m-media')
        @slot('variation', 'o-blocks__block')
        @slot('embed_height', $embed_height)
        @slot('item', [
            'type' => 'embed',
            'size' => 's',
            'media' => [
                "embed" => $embed_code,
                "src" => (isset($image['src'])) ? $image['src'] : '',
                "srcset" => (isset($image['src'])) ? $image['src'] : '',
                "width" => (isset($image['width'])) ? $image['width'] : '',
                "height" => (isset($image['height'])) ? $image['height'] : '',
                "shareUrl" => '#',
                "shareTitle" => '',
                "downloadUrl" => '',
                "downloadName" => '',
                "credit" => '',
                "creditUrl" => '',
            ],
            'caption' => '',
        ])
    @endcomponent
@endif
