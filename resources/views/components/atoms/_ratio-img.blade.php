<{{ $tag ?? 'span' }} class="ratio-img ratio-img--{{ $fillMode ?? 'cover' }}{{ (isset($ratio)) ? ' ratio-img--'.$ratio : '' }}{{ (isset($variation)) ? ' '.$variation : '' }}">
    @component('components.atoms._img')
        @slot('src', $image['src'])
        @slot('width', $image['width'])
        @slot('height', $image['height'])
    @endcomponent
</{{ $tag ?? 'span' }}>
