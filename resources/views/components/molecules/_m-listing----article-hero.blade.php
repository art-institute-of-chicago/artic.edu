<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{{ $item->slug }}" class="m-listing__link">
        <span class="m-listing__img">
            @component('components.atoms._img')
                @slot('src', $item->image['src'])
                @slot('width', $item->image['width'])
                @slot('height', $item->image['height'])
            @endcomponent
        </span>
        <span class="m-listing__meta">
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
                @component('components.atoms._date')
                    {{ $item->date }}
                @endcomponent
            </span>
        </span>
    </a>
</{{ $tag or 'li' }}>
