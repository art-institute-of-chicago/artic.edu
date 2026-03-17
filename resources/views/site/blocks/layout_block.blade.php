@php
    /** @var \A17\Twill\Services\Blocks\RenderData $renderData */

    $styles = [
        'display' => $block->input('display'),
        'gap' => $block->input('gap'),
        'padding-top' => $block->input('padding_top'),
        'padding-bottom' => $block->input('padding_bottom'),
        'padding-left' => $block->input('padding_left'),
        'padding-right' => $block->input('padding_right'),
        'margin-top' => $block->input('margin_top'),
        'margin-bottom' => $block->input('margin_bottom'),
        'margin-left' => $block->input('margin_left'),
        'margin-right' => $block->input('margin_right'),
    ];

    if ($block->input('display') === 'flex') {
        $styles['flex-direction'] = $block->input('flex_direction');
        $styles['justify-content'] = $block->input('justify_content');
        $styles['align-items'] = $block->input('align_items');
        $styles['flex-wrap'] = $block->input('flex_wrap') ? 'wrap' : 'nowrap';
    }

    if ($block->input('display') === 'grid' && $block->input('layout_type') !== 'default') {
        $styles['grid-template-columns'] = $block->input('layout_type');
    }

    if ($block->input('width') && $block->input('layout_type') === 'default') {
        $styles['width'] = $block->input('width');
    }

    $styleLine = collect($styles)->filter()->map(fn($v, $k) => "$k: $v")->implode('; ');
@endphp

<div
    id="{{ (isset($block->input('custom_id')) ? $block->input('custom_id') : $block->id) }}"
    class="{{ "o-blocks o-layout_block ". $block->input('custom_class') }}"
    style="{{ 'max-height: 100%; height: 100%; '. $styleLine }}"
>
    {!! $renderData->renderChildren('layout_block_blocks') !!}
</div>
