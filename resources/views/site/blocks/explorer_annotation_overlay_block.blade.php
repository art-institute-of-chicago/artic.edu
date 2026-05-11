@php
    /** @var \A17\Twill\Services\Blocks\RenderData $renderData */
    $fullWidth = $block->input('full_width');
@endphp

<div class="o-blocks o-explorer_annotation_overlay {{ $fullWidth ? 'is-full-width' : '' }}">
    @if($fullWidth)
        <div class="full-width-content">
            {!! $renderData->renderChildren('full_width_block') !!}
        </div>
    @else
        <div class="left-side">
            {!! $renderData->renderChildren('left_block') !!}
        </div>
        <div class="right-side">
            {!! $renderData->renderChildren('right_blocks') !!}
        </div>
    @endif
</div>
