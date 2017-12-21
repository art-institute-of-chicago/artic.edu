<{{ $tag ?? 'a' }} class="arrow-link {{ (isset($font)) ? $font : 'f-link' }}{{ (isset($variation)) ? ' '.$variation : '' }}"{{ (isset($href)) ? ' href="'.$href : '"' }}>{{ $slot }}<svg aria-hidden="true" class="icon--arrow"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow"></use></svg></{{ $tag ?? 'a' }}>

