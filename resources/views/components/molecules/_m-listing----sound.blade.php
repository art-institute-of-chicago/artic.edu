{{-- This assumes `href` is a direct link to an MP3 file --}}
<li class="m-listing m-listing--inline m-listing--sound">
    <div class="m-listing__link">
        <div class="m-listing__meta">
            {!! $item->title !!}
        </div>
        <div>
            <audio
                class="video-js vjs-fluid m-vjs-audio"
                {!! isset($item->transcript) ? 'data-transcript-uri="' . $item->transcript . '"' : null !!}
                controls
            >
                <source src="{{ $item->href }}" type="audio/mpeg">
                Your browser does not support the audio tag.
            </audio>
        </div>
        <div class="m-listing__subtitle">
            @if ($item->subtitle)
                {!! $item->subtitle !!}
            @endif
        </div>
    </div>
</li>
