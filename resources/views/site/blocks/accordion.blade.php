@php
    $items = [];
    foreach ($block->children as $item) {
        $item->title = $item->present()->input('header');
        $item->blocks = [
            [
                'type' => 'text',
                'content' => $item->present()->input('description')
            ]
        ];

        $items[] = $item;
    }
@endphp

@component('components.organisms._o-accordion')
    @slot('variation', 'o-blocks__block')
    @slot('titleFont', null)
    @slot('items', $items)
    @slot('loopIndex', $block->id)
@endcomponent
