<{{ $tag ?? 'a' }} class="link {{ (isset($font)) ? $font : 'f-link' }}{{ (isset($variation)) ? ' '.$variation : '' }}"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes : '' !!}{!! (isset($href)) ? ' href="'.$href. '"' : '' !!}>{{ $slot }}</{{ $tag ?? 'a' }}>

