@php
    global $_collectedReferences;
    if (!isset($_collectedReferences)) {
        $_collectedReferences = [];
    }
    list($quote, $_collectedReferences) = StringHelpers::convertReferenceLinks($block->present()->input('quote'), $_collectedReferences);
    list($attribution, $_collectedReferences) = StringHelpers::convertReferenceLinks($block->present()->input('attribution'), $_collectedReferences);
@endphp
@component('components.atoms._quote')
    @slot('variation', (isset($editorial) and $editorial) ? 'quote--editorial o-blocks__block' : 'o-blocks__block')
    @slot('font', (isset($editorial) and $editorial) ? 'f-deck' : null)

    @if (!empty($block->input('attribution')))
        @slot('attribution', $attribution)
    @endif

    {!! $quote !!}
@endcomponent
