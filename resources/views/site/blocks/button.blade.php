@component('components.atoms._btn')
    @slot('tag', 'a')
    @slot('variation', 'o-blocks__block btn-module')
    @slot('href', $block->present()->input('link'))
    {!! $block->present()->input('title') !!}
@endcomponent
