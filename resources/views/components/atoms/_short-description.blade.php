<{{ $tag ?? 'span' }} class="short-description {{ $font ?? 'f-secondary' }}{{ (isset($variation)) ? ' '.$variation : '' }}">{{ $slot }}</{{ $tag ?? 'span' }}>
