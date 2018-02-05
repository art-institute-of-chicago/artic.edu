<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{{ $item->slug }}" class="m-listing__link">
        <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}">
            @if ($item->image)
                @component('components.atoms._img')
                    @slot('src', $item->image['src'])
                    @slot('width', $item->image['width'])
                    @slot('height', $item->image['height'])
                @endcomponent
            @endif
        </span>
        <span class="m-listing__meta">
            @if ($item->subtype)
            <em class="type f-tag">{{ $item->subtype }}</em>
            <br>
            @endif
            @component('components.atoms._title')
                @slot('font', $titleFont ?? 'f-list-3')
                {{ $item->title }}
            @endcomponent
            @if ($item->intro)
            <br>
            <span class="intro {{ $captionFont ?? 'f-secondary' }}">{{ $item->intro }}</span>
            @endif
            @if ($item->shortDesc)
            <br>
            <span class="intro {{ $captionFont ?? 'f-secondary' }}">{{ $item->shortDesc }}</span>
            @endif
            @if ($item->date)
            <br>
            @component('components.atoms._date')
                {{ date( 'F j, Y', intval($item->date)) }}
            @endcomponent
            @endif
        </span>
    </a>
</{{ $tag or 'li' }}>
