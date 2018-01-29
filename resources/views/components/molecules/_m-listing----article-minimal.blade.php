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
            <em class="type f-tag">{{ $item->subtype }}</em>
            <br>
            <strong class="title {{ $titleFont ?? 'f-list-3' }}">{{ $item->title }}</strong>
            <br>
            <span class="m-listing__meta-bottom">
                <span class="intro f-caption">{{ $item->date }}</span>
            </span>
        </span>
    </a>
</{{ $tag or 'li' }}>
