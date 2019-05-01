@component('components.atoms._quote')
    @slot('variation', (isset($editorial) and $editorial) ? 'quote--editorial o-blocks__block' : 'o-blocks__block')
    @slot('font', (isset($editorial) and $editorial) ? 'f-deck' : null)

    @if (!empty($block->input('attribution')))
        @slot('attribution', $block->present()->input('attribution'))
    @endif

    {!! $block->present()->input('quote') !!}
@endcomponent
