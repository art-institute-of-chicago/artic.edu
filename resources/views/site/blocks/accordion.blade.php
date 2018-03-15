@php
    $items = [];
    foreach ($block->childs as $item) {
        $item->title = $item->input('header');
        $item->shortDesc = $item->input('description');
        $items[] = $item;
    }
@endphp

@component('components.organisms._o-accordion')
    @slot('variation', 'o-blocks__block')
    @slot('titleFont', null)
    @slot('items', $items)
    @slot('loopIndex', $loop->iteration)
@endcomponent
