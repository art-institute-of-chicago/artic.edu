@php
    $embed_code = $block->input('embed_code');
@endphp

@if ($embed_code)
    @component('components.molecules._m-media')
        @slot('variation', 'o-blocks__block')
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
            'caption' => ''
        ])
    @endcomponent
@endif
