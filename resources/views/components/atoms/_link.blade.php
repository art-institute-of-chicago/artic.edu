<{{ $tag ?? 'a' }}
    @class([
        'link',
        $font ?? 'f-link',
        $variation ?? null,
    ])
    {!! (isset($behavior)) ? ' data-behavior="'.$behavior.'"' : '' !!}
    {!! (isset($dataHref)) ? ' data-href="'.$dataHref.'"' : '' !!}
    {!! (isset($dataAttributes)) ? ' '.$dataAttributes : '' !!}
    {!! (isset($gtmAttributes)) ? ' '.$gtmAttributes : '' !!}
    {!! (isset($href)) ? ' href="'.$href. '"' : '' !!}
>
    {{ $slot }}
</{{ $tag ?? 'a' }}>
