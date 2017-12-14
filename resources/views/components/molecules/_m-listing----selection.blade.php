<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{{ $selection->slug }}" class="m-listing__link">
        <span class="m-listing__img m-listing__img--tall">
            @component('components.atoms._img')
                @slot('src', $selection->image['src'])
                @slot('width', $selection->image['width'])
                @slot('height', $selection->image['height'])
            @endcomponent
        </span>
        <span class="m-listing__meta">
            <em class="type f-tag">Selection</em>
            <br>
            <strong class="title f-list-3">{{ $selection->title }}</strong>
        </span>
    </a>
</{{ $tag or 'li' }}>
