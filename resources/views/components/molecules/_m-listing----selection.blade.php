<{{ $tag ?? 'li' }} class="m-listing m-listing--selection{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{!! route('selections.show', $item) !!}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
        <span class="m-listing__img m-listing__img--no-bg{{ (isset($imgVariation)) ? ' '.$imgVariation : ' m-listing__img--square' }}{{ (isset($singleImage) and $singleImage) ? '' : ' m-listing__img--w-overflow' }}">
            @if (isset($singleImage) and $singleImage)
                @component('components.atoms._img')
                    @slot('image', $item->imageFront('hero') ?? $item->images[0])
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
            @elseif (isset($item->images) and $item->images)
                @component('components.molecules._m-image-stack')
                    @slot('images', $item->images)
                    @slot('imageSettings', $imageSettings ?? null)
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
            <em class="type f-tag">{{isset($variation) && $variation == 'm-listing--feature' ? 'Collection ' : '' }}{!! $item->present()->subtype !!}</em>
            <br>
            @component('components.atoms._title')
                @slot('font', $titleFont ?? 'f-list-3')
                @slot('title', $item->present()->title)
                @slot('title_display', $item->present()->title_display)
            @endcomponent
        </span>
    </a>
</{{ $tag ?? 'li' }}>
