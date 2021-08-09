{{-- This assumes `href` is a direct link to an MP3 file --}}
<li class="m-listing m-listing--inline m-listing--sound">
    <div class="m-listing__link">
        @if (!empty($item->title))
            <div class="m-listing__meta--sound">
                {!! $item->title !!}
            </div>
        @endif
        <div>
            <audio
                class="video-js vjs-fluid m-vjs-audio {{ empty($item->title) ? 'm-vjs-audio--collapse' : '' }}"
                {!! isset($item->transcript) ? 'data-has-transcript' : null !!}
                data-gtm-prefix="{!! $item->gtmPrefix ?? 'audio' !!}"
                data-gtm-title="{!! !empty($item->title) ? strip_tags($item->title) : basename($item->href) !!}"
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
    </div>
</li>
