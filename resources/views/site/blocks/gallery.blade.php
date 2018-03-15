@php
    $subtype = $block->input('layout') == 1 ? 'mosaic' : 'slider';

    $items = [];
    foreach ($block->childs as $item) {
        $item->type = 'image';
        $item->media = $item->imageAsArray('image', 'desktop');
        $item->captionTitle = $item->input('captionTitle');
        $item->caption = $item->input('caption');
        $items[] = $item;
    }
@endphp

@component('components.organisms._o-gallery----'.$subtype)
    @slot('variation', 'o-blocks__block')
    @slot('title', $block->input('title'))
    @slot('caption', $block->input('description'))
    @slot('items', $items)
@endcomponent
