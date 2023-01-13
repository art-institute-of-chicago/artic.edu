@php
    $items = [];

    foreach ($block->childs as $item) {
        $mediaItem = [
            'type' => 'image',
            'size' => $block->input('size'),
            'media' => $item->imageAsArray('image', 'desktop'),
            'label' => $item->input('label'),
        ];

        $items[] = $mediaItem;
    }
@endphp

@if (count($items) > 0)
    @component('components.organisms._o-layered-image-viewer')
        @slot('variation', 'o-blocks__block')
        @slot('items', $items)
        @slot('imageSettings', $imageSettings ?? array(
                'srcset' => array(200,400,600,1000,1500,3000),
                'sizes' => ImageHelpers::aic_imageSizes(array(
                    'xsmall' => '58',
                    'small' => '28',
                    'medium' => '28',
                    'large' => '28',
                    'xlarge' => '21',
                )),
            ))
    @endcomponent
@endif
