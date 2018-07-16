{{-- This assumes `href` is a direct link to an MP3 file --}}
<li class="m-listing m-listing--inline m-listing--sound">
    <div class="m-listing__link">
        <div>
            <span class="m-listing__meta">
                <em class="type f-tag">Audio</em>
                <br>
                <strong class="title f-list-3">{!! $item->title !!}</strong>
            </span>
        </div>
        <div>
            <audio controls>
              <source src="{{ $item->href }}" type="audio/mpeg">
              Your browser does not support the audio tag.
            </audio>
        </div>
    </div>
</li>
