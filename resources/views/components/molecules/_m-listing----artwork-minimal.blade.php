<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{{ $item->slug }}" class="m-listing__link">
        <span class="m-listing__img m-listing__img--tall m-listing__img--contain">
            @component('components.atoms._img')
                @slot('src', $item->image['src'])
                @slot('width', $item->image['width'])
                @slot('height', $item->image['height'])
            @endcomponent
        </span>
    </a>
</{{ $tag or 'li' }}>
