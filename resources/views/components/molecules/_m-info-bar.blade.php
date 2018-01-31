<div class="m-info-bar o-blocks{{ (isset($variation)) ? ' '.$variation : '' }}{{ (isset($icon)) ? ' m-info-bar--w-icon' : '' }}">
    @component('components.blocks._blocks')
        @slot('blocks', $blocks ?? null)
    @endcomponent
    @if (isset($icon))<svg class="m-info-bar__icon {{ $icon }}" aria-hidden="true"><use xlink:href="#{{ $icon }}" /></svg>@endif
</div>
