@php
    $subtype = $block->input('layout') == 1 ? 'mosaic' : 'slider';
    $images = $block->imagesAsArrays('image', 'desktop');

    $items = [];
    foreach($images as $image) {
        $item = [];
        $item['type'] = 'image';
        $item['media'] = $image;
        $items[] = $item;
    }
@endphp

@component('components.organisms._o-gallery----'.$subtype)
    @slot('variation', 'o-blocks__block')
    @slot('title', $block->input('label'))
    @slot('caption', $block->input('subhead'))
    @slot('items', $items)
@endcomponent
