<{{ $tag ?? 'a' }} class="arrow-link {{ (isset($font)) ? $font : 'f-link' }}{{ (isset($variation)) ? ' '.$variation : '' }}"{!! (isset($href)) ? ' href="'.$href.'"' : '' !!}{!! (isset($itemprop)) ? ' itemprop="'.$itemprop.'"' : '' !!}>
    @if (isset($variation) && strrpos($variation, "--up") > 0)
        {!! $slot !!}<svg aria-hidden="true" class="icon--arrow"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow"></use></svg>
    @elseif (isset($variation) && strrpos($variation, "--down") > 0)
        {!! $slot !!}<svg aria-hidden="true" class="icon--arrow"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow"></use></svg>
    @elseif (isset($variation) && strrpos($variation, "--back") > 0)
        &lsaquo;&nbsp;&nbsp;{!! $slot !!}
    @else
        {!! $slot !!}&nbsp;&nbsp;&rsaquo;
    @endif
</{{ $tag ?? 'a' }}>

