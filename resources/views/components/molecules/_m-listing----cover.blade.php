<{{ $tag ?? 'li' }} class="m-listing m-listing----cover{{ (isset($variation)) ? ' '.$variation : '' }}">
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
        @component('components.atoms._title')
            @slot('font', $titleFont ?? 'f-list-4')
            @slot('title', $title)
            @slot('variation', 'm-listing----cover-title')
        @endcomponent
    </a>
    </{{ $tag ?? 'li' }}>