<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{!! route('selections.show', $item) !!}" class="m-listing__link">
        <span class="m-listing__img m-listing__img--no-bg{{ (isset($imgVariation)) ? ' '.$imgVariation : ' m-listing__img--square' }}">
            @if (isset($singleImage) and $singleImage)
                @component('components.atoms._img')
                    @slot('image', $item->imageFront('hero') ?? $item->images[0])
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
            @else
                @component('components.molecules._m-image-stack')
                    @slot('images', $item->images)
                    @slot('imageSettings', $imageSettings ?? null)
                @endcomponent
            @endif
        </span>
        <span class="m-listing__meta">
            <em class="type f-tag">Selection</em>
            <br>
            <strong class="title f-list-3">{{ $item->title }}</strong>
        </span>
    </a>
</{{ $tag or 'li' }}>
