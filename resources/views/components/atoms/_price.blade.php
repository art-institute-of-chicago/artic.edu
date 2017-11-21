@if (isset($salePrice))
<{{ $tag ?? 'span' }} class="price price--sale {{ $font ?? 'f-secondary' }}{{ (isset($variation)) ? ' '.$variation : '' }}"><strike>{{ $salePrice }}</strike> <em>{{ $slot }}</em></{{ $tag ?? 'span' }}>
@else
<{{ $tag ?? 'span' }} class="price {{ $font ?? 'f-secondary' }}{{ (isset($variation)) ? ' '.$variation : '' }}">{{ $slot }}</{{ $tag ?? 'span' }}>
@endif
