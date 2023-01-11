@php
    $image = $block->imageAsArray('image', 'desktop');
@endphp

@if (isset($image['src']))
    @component('components.molecules._m-layered-image-viewer')
        @slot('variation', 'o-blocks__block')
        @slot('item', [
            'type' => 'image',
            'size' => $block->input('size'),
            'media' => [
                'src' => $image['src'],
                'srcset' => $image['src'],
                'width' => $image['width'] ?? 0,
                'height' => $image['height'] ?? 0,
                'shareUrl' => '#',
                'shareTitle' => $block->present()->input('caption'),
                'downloadUrl' => $image['src'],
                'downloadName' => '',
                'credit' => '',
                'creditUrl' => '',
                'alt' => $image['alt'],
                'restrict' => $image['restict'] ?? false,
            ],
        ])
    @endcomponent
@endif