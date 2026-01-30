<{{ $tag ?? 'a' }}
    class="link {{ (isset($font)) ? $font : 'f-link' }}{{ (isset($variation)) ? ' '.$variation : '' }}"
    {!! (isset($behavior)) ? ' data-behavior="'.$behavior.'"' : '' !!}
    {!! (isset($dataHref)) ? ' data-href="'.$dataHref.'"' : '' !!}
    {!! (isset($gtmAttributes)) ? ' '.$gtmAttributes : '' !!}
    {!! (isset($href)) ? ' href="'.$href. '"' : '' !!}
>
    {{ $slot }}
</{{ $tag ?? 'a' }}>
