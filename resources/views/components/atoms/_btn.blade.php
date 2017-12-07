<{{ $tag ?? 'button' }} class="btn {{ $font ?? 'f-buttons' }}{{ (isset($variation)) ? ' '.$variation : '' }}{{ (isset($disabled)) ? ' s-disabled' : '' }}{{ (isset($loading)) ? ' s-loading' : '' }}"{{ (isset($disabled)) ? ' disabled' : '' }}{{ (isset($behavior)) ? ' data-behavior='.$behavior.'' : '' }}{{ (isset($dataAttributes)) ? ' '.$dataAttributes.'' : '' }}{{ (isset($href)) ? ' href='.$href.'' : '' }}>
    @if (isset($icon))<svg class="{{ $icon }}" aria-hidden="true"><use xlink:href="#{{ $icon }}" /></svg>@endif
    {{ $slot }}
</{{ $tag ?? 'button' }}>
