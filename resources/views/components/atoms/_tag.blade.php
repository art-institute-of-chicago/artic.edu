<{{ $tag ?? 'a' }}{{ isset($href) ? ' href="'.$href."'" : '' }} class="tag {{ $font ?? 'f-tag' }}{{ (isset($variation)) ? ' '.$variation : '' }}">{{ $slot }}</{{ $tag ?? 'a' }}>
