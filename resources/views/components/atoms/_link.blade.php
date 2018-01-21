<{{ $tag ?? 'a' }} class="arrow-link {{ (isset($font)) ? $font : 'f-link' }}{{ (isset($variation)) ? ' '.$variation : '' }}"{{ (isset($href)) ? ' href="'.$href : '"' }}>{{ $slot }}</{{ $tag ?? 'a' }}>

