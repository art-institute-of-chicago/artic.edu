<{{ $tag ?? 'span' }} class="ratio-img ratio-img--{{ $fillMode ?? 'cover' }}{{ (isset($ratio)) ? ' ratio-img--'.$ratio : '' }}{{ (isset($variation)) ? ' '.$variation : '' }}">
    @component('components.atoms._img')
        @slot('image', $image)
        @slot('settings', $imageSettings ?? '')
    @endcomponent
</{{ $tag ?? 'span' }}>
