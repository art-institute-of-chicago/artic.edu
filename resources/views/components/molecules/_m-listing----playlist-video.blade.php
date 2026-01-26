<li @class(['m-listing', 'playlist-video', 'current-video' => $isCurrent])>
    @if (isset($url))
        <a href="{!! $url !!}" class="m-listing__link">
    @endif
    <span class="m-listing__img">
        @if (isset($image))
            @component('components.atoms._img')
                @slot('image', $image)
                @slot('settings', $imageSettings ?? '')
            @endcomponent
        @else
            <span class="default-img"></span>
        @endif
    </span>
    <span class="m-listing__meta">
        @if (isset($title))
            @component('components.atoms._title')
                @slot('font', 'f-list-3')
                @slot('title', $title)
            @endcomponent
        @endif
    </span>
    @if (isset($url))
        </a>
    @endif
</li>
