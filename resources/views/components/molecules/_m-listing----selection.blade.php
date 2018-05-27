<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{!! route('selections.show', $item) !!}" class="m-listing__link">
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
        </span>
        <span class="m-listing__meta">
            <em class="type f-tag">{{ $item->sub_type }}</em>
            <br>
            <strong class="title f-list-3">{{ $item->title }}</strong>
        </span>
    </a>
</{{ $tag or 'li' }}>
