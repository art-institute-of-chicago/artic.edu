@php
    $subtype = $block->input('layout') == 1 ? 'mosaic' : 'slider';

    $items = [];
    foreach ($block->childs as $item) {
        $item->type = 'image';
        $item->size = 'gallery';
        $item->fullscreen = true;
        $item->media = $item->imageAsArray('image', 'desktop');
        $item->captionTitle = $item->present()->input('captionTitle');
        $item->caption = $item->present()->input('caption');
        $items[] = $item;
    }
@endphp

@component('components.organisms._o-gallery----'.$subtype)
    @if ($subtype === 'mosaic')
        @slot('imageSettings', array(
            'srcset' => array(200,400,600,1000,1500,3000,4500),
            'sizes' => aic_imageSizes(array(
                  'xsmall' => '58',
                  'small' => '28',
                  'medium' => '28',
                  'large' => '28',
                  'xlarge' => '21',
            )),
        ))
    @endif
    @if ($subtype === 'slider')
        @slot('imageSettings', array(
            'srcset' => array(200,400,600,1000,1500,3000,4500),
            'sizes' => aic_imageSizes(array(
                  'xsmall' => '50',
                  'small' => '35',
                  'medium' => '23',
                  'large' => '23',
                  'xlarge' => '18',
            )),
        ))
    @endif

    @slot('variation', 'o-blocks__block o-gallery----theme-' . ($block->input('theme') ?? 'dark'))
    @slot('title', $block->present()->input('title'))
    @slot('caption', $block->present()->input('description'))
    @slot('allLink', null);
    @slot('items', $items)
@endcomponent
