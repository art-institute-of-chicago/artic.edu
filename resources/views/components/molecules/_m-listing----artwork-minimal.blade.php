<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{{ $artwork->slug }}" class="m-listing__link">
        <span class="m-listing__img m-listing__img--tall m-listing__img--contain">
            @component('components.atoms._img')
                @slot('src', $artwork->image['src'])
                @slot('width', $artwork->image['width'])
                @slot('height', $artwork->image['height'])
            @endcomponent
        </span>
    </a>
</{{ $tag or 'li' }}>
