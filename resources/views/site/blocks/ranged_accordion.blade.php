@php

    $type = $block->input('type');
    $title = $block->input('title') ?? null;

@endphp

<div class="o-accordion{{ (isset($variation)) ? ' '.$variation : '' }}" data-behavior="accordion">
    @if ($type === 'start')
    <h3><button id="{{ StringHelpers::getUtf8Slug($title) }}" class="o-accordion__trigger {{ $titleFont ?? 'f-list-3' }}" tabindex="0">
        {!! $title !!}
        <span class="o-accordion__trigger-icon">
            <svg class="icon--plus"><use xlink:href="#icon--plus" /></svg>
            <svg class="icon--minus"><use xlink:href="#icon--minus" /></svg>
        </span>
    </button></h3>
    <div id="panel_{{ StringHelpers::getUtf8Slug($title) }}" class="o-accordion__panel" aria-labelledby="{{ StringHelpers::getUtf8Slug($title)}}">
        <div class="o-accordion__panel-content o-blocks">
    @else
            </div>
        </div>
    </div>
    </div>
    @endif
