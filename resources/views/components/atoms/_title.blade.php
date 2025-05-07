<{{ $tag ?? 'strong' }}
    {!! (isset($id)) ? ' id="'.$id.'"' : '' !!}
    {!! (isset($href)) ? ' href="'.$href.'"' : '' !!}
    class="title {{ $font ?? 'f-list-2' }} {{ (isset($variation)) ? ' '.$variation : '' }}"
    {!! (isset($itemprop)) ? ' itemprop="'.$itemprop.'"' : '' !!}
    {!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}
    {!! (isset($ariaHidden)) ? ' aria-hidden="' .$ariaHidden .'"' : '' !!}
>
    {!! $title_display ?? $title ?? html_entity_decode($slot) !!}
</{{ $tag ?? 'strong' }}>
