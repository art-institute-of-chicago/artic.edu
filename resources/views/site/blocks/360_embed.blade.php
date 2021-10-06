@php
    $image_sequence_file = $block->assetLibrary;
    $sequence_id = $image_sequence_file['id'];
    $alt_text = $block->input('alt_text');
    $caption_title = $block->input('caption_title');
    $caption = $block->input('caption');
    $size = $block->input('size');
@endphp

@if ($image_sequence_file)

    <div class="m-media m-media--{{ $size ?? 's' }} m-media--contain o-blocks__block">
        <script type="application/json" id="assetLibrary-{!!$sequence_id!!}">
            {!! json_encode($block->assetLibrary) !!}
        </script>
        <div class="m-media__img m-media--360-embed" data-behavior="fitText">
        @component('components.molecules._m-viewer-360')
            @slot('type', 'standalone')
            @slot('title', $alt_text ?? (isset($pageTitle) ? $pageTitle.' - Inline 360' : 'Inline 360'))
            @slot('id', 'assetLibrary-'.$sequence_id);
        @endcomponent
        </div>
        @if ($caption_title || $caption)
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
