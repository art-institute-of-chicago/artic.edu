@php
    $items = [];

    foreach ($block->childs as $item) {
        $mediaItem = [
            'type' => 'image',
            'size' => 'gallery',
            'fullscreen' => $block->input('disable_image_modals') ? false : true,
            'media' => $item->imageAsArray('image', 'desktop'),
        ];

        if (($block->input('is_gallery_zoomable') ?? false) || $item->input('is_zoomable')) {
            if (isset($mediaItem['media'])) {
                $mediaItem['media']['iiifId'] = $item->getImgixTileSource('image', 'desktop');
            }
        }

        $items[] = $mediaItem;
    }
@endphp

@if (count($items) > 0)
    @component('components.organisms._o-layered-image-viewer')
        @slot('variation', 'o-blocks__block')
        @slot('items', $items)
    @endcomponent
@endif
