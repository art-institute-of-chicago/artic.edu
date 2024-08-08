<{{ $tag ?? 'li' }} class="m-listing m-listing--digital-publication-article-entry m-listing--w-meta-bottom{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{{ $href }}" class="m-listing__link">
        <span class="m-listing__img">
            @if ($image)
                @component('components.atoms._img')
                    @slot('image', $image)
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
            @else
                <span class="default-img"></span>
            @endif
            <span class="m-listing__img__overlay">
                <svg class="icon--slideshow--24">
                    <use xlink:href="#icon--slideshow--24"></use>
                </svg>
            </span>
        </span>
        <span class="m-listing__meta">
            @if (isset($label))
                @component('components.atoms._type')
                    @slot('font', 'f-secondary')
                    {!! $label !!}
                @endcomponent
                <br>
            @endif
            @component('components.atoms._title')
                @slot('font', 'f-list-4')
                @slot('title', $title)
                @slot('title_display', $title_display)
                @slot('itemprop', 'name')
            @endcomponent
        </span>
    </a>
</{{ $tag ?? 'li' }}>
