<li class="m-listing">
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
        @if (isset($label))
            <span class="m-listing__img-prompt f-buttons">
                {{ $label }}
            </span>
        @endif
    </span>

    <span class="m-listing__meta">
        @if (isset($tag))
            <em class="type f-tag">{!! $tag !!}</em>
            <br>
        @endif
        @if (isset($title))
            @component('components.atoms._title')
                @slot('font', 'f-list-3')
                @slot('title', $title)
            @endcomponent
        @endif
        @if (isset($description))
            <br>
            <span class="intro f-secondary">{!! $description !!}</span>
        @endif
    </span>

    @if (isset($url))
    </a>
    @endif
</li>
