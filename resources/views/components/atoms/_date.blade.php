<{{ $tag ?? 'span' }} class="date {{ $font ?? 'f-secondary' }}{{ (isset($variation)) ? ' '.$variation : '' }}">{{ $slot }}</{{ $tag ?? 'span' }}>
