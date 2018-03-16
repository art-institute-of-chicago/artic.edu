@php
    $items = [
        [
            'href'  => $block->input('link'),
            'label' => $block->input('title'),
            'iconAfter' => 'new-window'
        ]
    ];
@endphp

@component('components.molecules._m-link-list')
    @slot('variation', 'o-blocks__block')
    @slot('links', $items);
@endcomponent
