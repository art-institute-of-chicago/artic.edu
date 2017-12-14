<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{{ $artwork->slug }}" class="m-listing__link">
        <span class="m-listing__img m-listing__img--square">
            @component('components.atoms._img')
                @slot('src', $artwork->image['src'])
                @slot('width', $artwork->image['width'])
                @slot('height', $artwork->image['height'])
            @endcomponent
        </span>
        <span class="m-listing__meta">
            <em class="type f-tag">{{ $artwork->sku }}</em>
            <br>
            <strong class="title f-subheading-1">{{ $artwork->title }}</strong>
            <br>
            <span class="subtitle f-body">{{ $artwork->artist }}, {{ $artwork->date }}</span>
        </span>
    </a>
</{{ $tag or 'li' }}>
