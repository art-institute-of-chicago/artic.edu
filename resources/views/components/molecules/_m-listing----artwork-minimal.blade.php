<{{ $tag ?? 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}" itemscope itemtype="http://schema.org/CreativeWork">
    <a href="{!! route('artworks.show', $item) !!}" class="m-listing__link" aria-label="{{ $item->listingTitle }}, {{ $item->listingSubtitle }}" itemprop="url"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
        <span class="m-listing__img m-listing__img--contain m-listing__img--no-bg{{ (isset($imgVariation)) ? ' '.$imgVariation : '  m-listing__img--tall' }}{{ ($item->videoFront) ? ' m-listing__img--video' : '' }}">
            @if ($item->imageFront())
                @component('components.atoms._img')
                    @slot('image', $item->imageFront())
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
                @component('components.molecules._m-listing-video')
                    @slot('item', $item)
                    @slot('image', $image ?? null)
                @endcomponent
            @else
                <span class="default-img"></span>
            @endif
        </span>
    </a>
</{{ $tag ?? 'li' }}>
