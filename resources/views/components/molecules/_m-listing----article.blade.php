<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{{ $item->slug }}" class="m-listing__link">
        <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}">
            @if ($item->image)
                @component('components.atoms._img')
                    @slot('image', $item->image)
                    @slot('settings', $imageSettings ?? '')
                @endcomponent

                @if ($item->isVideo)
                    <svg class="icon--play--48"><use xlink:href="#icon--play--48" /></svg>
                @endif
            @endif
        </span>
        <span class="m-listing__meta">
            <em class="type f-tag">{{ $item->subtype }}</em>
            <br>
            @component('components.atoms._title')
                @slot('font', $titleFont ?? 'f-list-3')
                {{ $item->title }}
            @endcomponent
            <br>
            <span class="intro {{ $captionFont ?? 'f-caption' }}">{{ $item->intro }}</span>
        </span>
    </a>
</{{ $tag or 'li' }}>
