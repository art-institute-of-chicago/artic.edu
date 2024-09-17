@php

    $type = $block->input('type');
    $title = $block->input('title') ?? null;

@endphp

@if ($type === 'start')
    <div class="o-accordion{{ (isset($variation)) ? ' '.$variation : '' }} o-ranged-accordion" data-behavior="rangedAccordion">
        <h3><button id="accordion_{{ StringHelpers::getUtf8Slug($title) }}" class="o-accordion__trigger {{ $titleFont ?? 'f-module-title-2' }}" tabindex="0">
            {!! $title !!}
            <span class="o-accordion__trigger-icon">
                <svg class="icon--plus"><use xlink:href="#icon--plus" /></svg>
                <svg class="icon--minus"><use xlink:href="#icon--minus" /></svg>
            </span>
        </button></h3>
        <div id="panel_accordion_{{ StringHelpers::getUtf8Slug($title) }}" class="o-accordion__panel" aria-labelledby="{{ StringHelpers::getUtf8Slug($title)}}">
            <div class="o-accordion__panel-content o-blocks o-blocks--with-sidebar">
@else
            </div>
        </div>
    </div>
@endif
