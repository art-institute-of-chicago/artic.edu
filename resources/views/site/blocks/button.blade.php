@component('components.atoms._btn')
    @slot('tag', 'a')
    @slot('variation', 'o-blocks__block btn-module')
    @slot('href', $block->input('link'))
    {{ $block->input('title') }}
@endcomponent
