{{-- This assumes `href` is a direct link to an MP3 file --}}
<li class="m-listing m-listing--inline m-listing--sound">
    <div class="m-listing__link">
        <div class="m-listing__meta">
            {!! $item->title !!}
        </div>
        <div>
            <audio
                class="video-js vjs-fluid m-vjs-audio"
                {!! isset($item->transcript) ? 'data-has-transcript' : null !!}
                controls
            >
                <source src="{{ $item->href }}" type="audio/mpeg">
                Your browser does not support the audio tag.
            </audio>
        </div>
        @if (isset($item->transcript))
        <div class="m-listing--sound__transcript" aria-hidden="true">
            <div>{!! $item->transcript !!}</div>
        </div>
        @endif
        @if (isset($item->subtitle))
        <div class="m-listing--sound__subtitle">
            {!! $item->subtitle !!}
        </div>
        @endif
    </div>
</li>
