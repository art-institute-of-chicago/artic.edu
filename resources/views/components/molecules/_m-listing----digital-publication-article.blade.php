<{{ $tag ?? 'li' }} class="m-listing m-listing--digital-publication-article m-listing--w-meta-bottom{{ (isset($variation)) ? ' '.$variation : '' }}">
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
            @if (isset($type))
                @component('components.atoms._type')
                    {!! $type !!}
                @endcomponent
                <br>
            @endif
            @component('components.atoms._title')
                @slot('font', 'f-list-4')
                @slot('title', $title)
                @slot('title_display', $title_display)
                @slot('itemprop', 'name')
            @endcomponent
            <br>
            @if ($author_display)
                <span class="f-secondary">By {{ $author_display }}</span>
            @endif
            <br>
            <span class="m-listing__meta-bottom">
            @if ($list_description)
                @component('components.atoms._short-description')
                    @slot('font', 'f-body')
                    {!! $list_description !!}
                @endcomponent
            @endif
            <br>
            @component('components.atoms._link')
                @slot('font', 'f-secondary')
                @slot('href', $href)
                Read full {{isset($type) ? Str::singular(Str::lower($type)) : 'article'}}<svg class="icon--arrow"><use xlink:href="#icon--arrow"></use></svg>
            @endcomponent
            </span>
        </span>
    </a>
</{{ $tag ?? 'li' }}>
