<{{ $tag ?? 'a' }} class="link {{ (isset($font)) ? $font : 'f-link' }}{{ (isset($variation)) ? ' '.$variation : '' }}"{!! (isset($href)) ? ' href="'.$href. '"' : '' !!}>{{ $slot }}</{{ $tag ?? 'a' }}>

