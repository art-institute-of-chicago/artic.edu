<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}" data-behavior="blurMyBackground">
    <a href="{{ $item->slug }}" class="m-listing__link">
        <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}" data-blur-img>
            @if ($item->imageFront())
                @component('components.atoms._img')
                    @slot('image', $item->imageFront())
                    @slot('settings', $imageSettings ?? '')
                @endcomponent

                @if ($item->isVideo)
                    <svg class="icon--play--48"><use xlink:href="#icon--play--48" /></svg>
                @endif
            @endif
        </span>
        <span class="m-listing__meta" data-blur-clip-to>
            @component('components.atoms._title')
                @slot('font', $titleFont ?? 'f-list-3')
                {{ $item->title }}
            @endcomponent
            <br>
            <span class="intro {{ $captionFont ?? 'f-caption' }}">{{ $item->intro }}</span>
            <br>
            <span class="m-listing__meta-bottom">
                @component('components.atoms._type')
                    {{ $item->subtype }}
                @endcomponent
                <br>
                @if ($item->date)
                    @component('components.atoms._date')
                        {{ $item->date->format('F j, Y') }}
                    @endcomponent
                @endif
            </span>
        </span>
    </a>
</{{ $tag or 'li' }}>
