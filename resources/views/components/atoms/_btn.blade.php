<{{ $tag ?? 'button' }} class="btn {{ $font ?? 'f-buttons' }}{{ (isset($variation)) ? ' '.$variation : '' }}{{ (isset($disabled)) ? ' s-disabled' : '' }}{{ (isset($loading)) ? ' s-loading' : '' }}"{!! (isset($id)) ? ' id="'.$id.'"' : '' !!}{{ (isset($disabled)) ? ' disabled' : '' }}{!! (isset($behavior)) ? ' data-behavior="'.$behavior.'"' : '' !!}{!! (isset($dataAttributes)) ? ' '.$dataAttributes.'' : '' !!}{!! (isset($href)) ? ' href="'.$href.'"' : '' !!}{!! (isset($type)) ? ' type="'.$type.'"' : '' !!}{{ (isset($download) and $download) ? ' download' : '' }}{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
    @if (isset($icon))<svg class="{{ $icon }}" aria-hidden="true"><use xlink:href="#{{ $icon }}" /></svg>@endif
    {{ $slot }}
</{{ $tag ?? 'button' }}>
