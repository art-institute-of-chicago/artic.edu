<{{ $tag ?? 'strong' }}{{ (isset($href)) ? ' href="'.$href : '"' }} class="title {{ $font ?? 'f-list-2' }}{{ (isset($variation)) ? ' '.$variation : '' }}">{{ $slot }}</{{ $tag ?? 'strong' }}>
