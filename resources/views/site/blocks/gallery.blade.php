@php
    $subtype = $block->input('layout') == 1 ? 'mosaic' : 'slider';
    $image = $block->imageAsArray('image', 'desktop');
@endphp

@component('components.organisms._o-gallery----'.$subtype)
    @slot('variation', 'o-blocks__block')
    @slot('title', $block->input('label'))
    @slot('caption', $block->input('subhead'))
    @slot('items', $image)
@endcomponent
