@php
    $type = $block->input('tag');
    $title_display = $block->input('title');
    $link_text = $block->input('link_text');
    $href = $block->input('link_url');
    $color = $block->input('color');
@endphp

@component('components.molecules._m-listing----publication-call-to-action')
    @slot('variation', (isset($color) && $color == 'alternate') ? 'm-listing--publication-call-to-action-alternate' : null)
    @slot('href', $href ?? null)
    @slot('type', $type ?? null)
    @slot('title_display', $title_display ?? null)
    @slot('link_text', $link_text ?? null)
@endcomponent

