@php
    $title = $item->display_title ?: $item->title;
@endphp
{{-- This assumes `href` is a direct link to an MP3 file --}}
<li class="m-listing m-listing--inline m-listing--sound">
    <div class="m-listing__link">
        @if (!empty($title))
            <div class="m-listing__meta--sound">
                {!! $title !!}
            </div>
        @endif
        <div>
            <audio
                @class([
                    'm-vjs-audio',
                    'm-vjs-audio--collapse' => $title,
                    'video-js',
                    'vjs-fluid',
                ])
                {!! isset($item->transcript) ? 'data-has-transcript' : null !!}
                data-gtm-prefix="{!! $item->gtmPrefix ?? 'audio' !!}"
                data-gtm-title="{!! !empty($title) ? strip_tags($title) : basename($item->href) !!}"
                controls
            >
                <source src="{{ $item->href }}" type="audio/mpeg">
                Your browser does not support the audio tag.
            </audio>
        </div>
        @if (!empty($item->transcript))
            <div class="m-listing--sound__transcript" aria-hidden="true">
                <div>{!! $item->transcript !!}</div>
            </div>
        @endif
        @if (!empty($item->subtitle))
            <div class="m-listing--sound__subtitle">
                {!! $item->subtitle !!}
            </div>
        @endif
        @if (isset($item->caption) or isset($item->captionTitle))
        <figcaption>
            @if (isset($item->captionTitle))
                <div class="{{ isset($item->caption) ? 'f-caption-title' : 'f-caption' }}"><div>
                    {!! $item->captionTitle !!}
                </div></div> <br>
            @endif
            @if (isset($item->caption))
                <div class="f-caption">{!! $item->caption !!}</div>
            @endif
        </figcaption>
        @endif
    </div>
</li>
