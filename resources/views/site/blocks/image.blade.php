@php
    $image = $block->imageAsArray('image', 'desktop');
@endphp

@if (isset($image['src']))
    @component('components.molecules._m-media')
        @slot('variation', 'o-blocks__block')
        @slot('item', [
            'type' => 'image',
            'size' => $block->input('size'),
            'caption' => $block->present()->input('caption'),
            'captionTitle' => $block->present()->input('caption_title'),
            'media' => [
                "src" => $image['src'],
                "srcset" => $image['src'],
                "width" => $image['width'] ?? 0,
                "height" => $image['height'] ?? 0,
                "shareUrl" => '#',
                "shareTitle" => $block->present()->input('caption'),
                "downloadUrl" => $image['src'],
                "downloadName" => '',
                "credit" => '',
                "creditUrl" => '',
                "alt" => $image['alt'],
            ],
        ])
    @endcomponent
@endif
