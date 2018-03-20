@php
    $items = [];
    foreach ($block->childs as $item) {
        $item->title = $item->input('header');
        $item->blocks = [
            [
                'type' => 'text',
                'content' => $item->input('description')
            ]
        ];

        $items[] = $item;
    }
@endphp

@component('components.organisms._o-accordion')
    @slot('variation', 'o-blocks__block')
    @slot('items', $items)
    @slot('loopIndex', $block->id)
@endcomponent
