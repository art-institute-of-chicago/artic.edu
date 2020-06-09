@php
    $image_sequence_file = $block->assetLibrary;
    $caption = $block->input('caption');
    $caption_title = $block->input('caption_title');
@endphp

@if ($image_sequence_file)
    <script type="application/json" id="assetLibrary">
        {!! json_encode($block->assetLibrary) !!}
    </script>

    <div class="m-media m-media--s o-blocks__block">
        <div class="m-media__img m-media--360-embed" data-behavior="fitText">
        @component('components.molecules._m-viewer-360')
            @slot('type', 'standalone')
            @slot('title', $pageTitle ? $pageTitle.' - Inline 360' : 'Inline 360')
        @endcomponent
        </div>
        @if ($caption)
            <figcaption>
                @if (isset($caption_title))
                    <div class="f-caption-title">{!! $caption_title !!}</div><br>
                @endif
                @if (isset($caption))
                    <div class="f-caption">{!! $caption !!}</div>
                @endif
            </figcaption>
        @endif
    </div>
@endif