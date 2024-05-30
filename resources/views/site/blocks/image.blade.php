@php
    $image = $block->imageAsArray('image', 'desktop');

    $title = $block->present()->input('caption_title');
    $subtitle = $block->present()->input('caption');

    $isModal = $block->input('is_modal') ?? false;
    $isZoomable = $isModal && $block->input('is_zoomable') ?? false;

    $theme = $block->input('theme') !== 'default' ? $block->input('theme') : null;
@endphp

@if (isset($image['src']))
    @component('components.molecules._m-media')
        @slot('variation', 'o-blocks__block' . ($theme ? ' image-block--' . $theme : ''))
        @slot('item', [
            'type' => 'image',
            'size' => $block->input('size'),
            'useContain' => $block->input('use_contain'),
            'useAltBackground' => $block->input('use_alt_background'),
            'fullscreen' => $isModal,
            'captionTitle' => $title,
            'caption' => $subtitle,
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
                'fullscreen' => $isZoomable,
                'iiifId' => $isZoomable
                    ? $block->getImgixTileSource('image', 'desktop')
                    : null,
            ],
            'showUrl' => !empty($block->input('image_link')),
            'showUrlFullscreen' => !empty($block->input('image_link')),
            'urlTitle' => $block->input('image_link') ?? null,
        ])
    @endcomponent
@endif
