@php
    $url = isset($url) ? $url : route('playlists.show', ['playlist' => $playlist]);
    $image = isset($image) ? $image : ImageHelpers::youtubeItemAsArray($playlist);
    $images = $playlist->videos()
        ->published()
        ->wherePivot('position', '>', 0)  // The first video thumbnail is the same as the playlist thumbnail
        ->get()
        ->take(2)
        ->map(fn($video) => ImageHelpers::youtubeItemAsArray($video));
    $videoCount = $playlist->videos()->published()->count();
    $label = isset($label) ? $label : $videoCount . ' ' . Str::plural('videos', $videosCount);
    $labelPosition = isset($labelPosition) ? $labelPosition : 'overlay';
    $title = isset($title) ? $title : $playlist->title;
    $tag = isset($tag) ? $tag : null;
    $description = isset($description) ? $description : null;
@endphp

<li class="m-listing">
    @if ($url)
        <a href="{!! $url !!}" class="m-listing__link">
    @endif
    <span
        @class([
            'm-listing__img',
            'm-listing__img--multiple' => $images->count(),
        ])
    >
        @if ($image)
            @component('components.atoms._img')
                @slot('image', $image)
                @slot('settings', $imageSettings ?? '')
            @endcomponent
            @if ($images->count())
                @foreach ($images as $image)
                    @component('components.atoms._img')
                        @slot('image', $image)
                        @slot('settings', $imageSettings ?? '')
                    @endcomponent
                @endforeach
            @endif
        @else
            <span class="default-img"></span>
        @endif
        @if ($label && $labelPosition == 'overlay')
            <span class="m-listing__img-prompt f-buttons">
                {{ $label }}
            </span>
        @endif
    </span>
    <span class="m-listing__meta">
        @if ($tag)
            <em class="type f-tag">{!! $tag !!}</em>
            <br>
        @endif
        @if ($title)
            @component('components.atoms._title')
                @slot('font', 'f-list-3')
                @slot('title', $title)
            @endcomponent
        @endif
        @if ($description)
            <br>
            <span class="intro f-secondary">{!! $description !!}</span>
        @endif
        @if ($label && $labelPosition == 'description')
        <span class="f-link">
            {{ $label }} <svg class='icon--arrow'><use xlink:href='#icon--arrow'></use></svg>
        </span>
    @endif
    </span>
    @if ($url)
        </a>
    @endif
</li>
