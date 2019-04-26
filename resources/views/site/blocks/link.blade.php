@php
    $file = $block->file('attachment');

    $link = $block->input('link');
    $label = $block->present()->input('title');

    if ($file) {
        if (empty($link)) {
            $link = $file;
        }

        if (empty($label)) {
            $parts = parse_url($file);
            $label = basename($parts['path']);
        }
    }

    $items = [
        [
            'href'  => $link,
            'label' => $label,
            'iconAfter' => 'new-window'
        ]
    ];
@endphp

@component('components.molecules._m-link-list')
    @slot('variation', 'o-blocks__block')
    @slot('links', $items);
@endcomponent
