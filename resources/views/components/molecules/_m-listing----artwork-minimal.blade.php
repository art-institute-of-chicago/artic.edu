<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{{ $item->slug }}" class="m-listing__link">
        <span class="m-listing__img m-listing__img--contain m-listing__img--no-bg{{ (isset($imgVariation)) ? ' '.$imgVariation : '  m-listing__img--tall' }}">
            @if ($item->image)
                @component('components.atoms._img')
                    @slot('image', $item->image)
                    @slot('sizes', $imageSizes ?? '')
                @endcomponent
            @endif
        </span>
    </a>
</{{ $tag or 'li' }}>
