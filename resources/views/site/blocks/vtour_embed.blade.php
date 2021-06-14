@php
    $vtourxml = $block->file('vtour_xml_file');
    $size = $block->input('size');
    $captionTitle = $block->input('caption_title');
    $captionText = $block->input('caption');
@endphp

@if ($vtourxml)
    <div class="m-media m-media--{{ (isset($size)) ? $size : 'l' }} o-blocks__block">

        <div class="m-media--vtour-embed" data-behavior="fitText">
            @component('components.molecules._m-viewer-virtualtour')
                @slot('type', 'standalone')
                @slot('title', isset($pageTitle) ? $pageTitle.' - Inline Virtual Tour' : 'Inline Virtual Tour')
                @slot('vtourxml', $vtourxml);
            @endcomponent
        </div>
        @if ($captionTitle || $captionText)
            <figcaption>
                @if (isset($captionTitle))
                    <div class="f-caption-title">{!! $captionTitle !!}</div><br>
                @endif
                @if (isset($captionText))
                    <div class="f-caption">{!! $captionText !!}</div>
                @endif
            </figcaption>
        @endif
    </div>
@endif
