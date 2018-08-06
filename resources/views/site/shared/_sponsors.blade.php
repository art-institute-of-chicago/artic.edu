@php
    $sponsor = $sponsors ? $sponsors->first() : null;
    $hasBlocks = $sponsor && $sponsor->blocks && $sponsor->blocks->count() > 0;
@endphp

@if ($hasBlocks)

    @component('components.blocks._text')
        @slot('font', 'f-module-title-2')
        @slot('tag', 'h4')
        Sponsors
    @endcomponent

    {!! $sponsor->renderBlocks() !!}

@endif
