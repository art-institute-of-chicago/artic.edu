<{{ $tag ?? 'a' }} class="arrow-link {{ (isset($font)) ? $font : 'f-link' }}{{ (isset($variation)) ? ' '.$variation : '' }}"{!! (isset($href)) ? ' href="'.$href.'"' : '' !!}{!! (isset($itemprop)) ? ' itemprop="'.$itemprop.'"' : '' !!}{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
    @if (isset($variation) && strrpos($variation, "--up") > 0)
        {!! $slot !!}<svg aria-hidden="true" class="icon--arrow"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow"></use></svg>
    @elseif (isset($variation) && strrpos($variation, "--down") > 0)
        {!! $slot !!}<svg aria-hidden="true" class="icon--arrow"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow"></use></svg>
    @elseif (isset($variation) && strrpos($variation, "--back") > 0)
        <span aria-hidden="true">&lsaquo;&nbsp;&nbsp;</span>{!! $slot !!}
    @else
        {!! $slot !!}<span aria-hidden="true">&nbsp;&nbsp;&rsaquo;</span>
    @endif
</{{ $tag ?? 'a' }}>
