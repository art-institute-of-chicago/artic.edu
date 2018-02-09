<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{{ $item->slug }}" class="m-listing__link">
        <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}">
            @if ($item->image)
                @component('components.atoms._img')
                    @slot('src', $item->image['src'])
                    @slot('srcset', $item->image['srcset'])
                    @slot('width', $item->image['width'])
                    @slot('height', $item->image['height'])
                @endcomponent

                @if ($item->isVideo)
                    <svg class="icon--play--48"><use xlink:href="#icon--play--48" /></svg>
                @endif
            @endif
        </span>
        <span class="m-listing__meta">
            <em class="type f-tag">{{ $item->subtype }}</em>
            <br>
            <strong class="title {{ $titleFont ?? 'f-list-3' }}">{{ $item->title }}</strong>
            <br>
            <span class="m-listing__meta-bottom">
                <span class="intro f-caption">
                    @if ($item->date)
                        @component('components.atoms._date')
                            {{ $item->date->format('F j, Y') }}
                        @endcomponent
                    @endif
                </span>
            </span>
        </span>
    </a>
</{{ $tag or 'li' }}>
