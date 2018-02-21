<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{{ $item->slug }}" class="m-listing__link">
        <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}">
            @if ($item->image)
                @component('components.atoms._img')
                    @slot('image', $item->image)
                    @slot('imageSettings', $imageSettings ?? null)
                @endcomponent
            @endif
        </span>
        <span class="m-listing__meta">
            <strong class="title {{ $titleFont ?? 'f-list-3' }}">{{ $item->title }}</strong>
            @if ($item->timeStamp)
            <br>
            <span class="subtitle f-secondary">{{ $item->timeStamp }}</span>
            @endif
        </span>
    </a>
</{{ $tag or 'li' }}>
