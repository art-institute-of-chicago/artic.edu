@if (!empty($block->input('header')))
    <h2>{{ $block->input('header') }}</h2>
@endif

@component('components.molecules._m-search-bar')
    @slot('variation', 'm-search-bar--block')
    @slot('name', 'm-search-bar-block-input')
    @slot('placeholder', $block->input('placeholder'))
    @slot('action', null)
    @slot('behaviors','searchBarBlock')
    @slot('dataAttributes', 'data-url="' . $block->input('url_template') . '"')
@endcomponent
