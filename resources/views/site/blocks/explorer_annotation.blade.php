@php
    /** @var \A17\Twill\Services\Blocks\RenderData $renderData */
@endphp

{{-- Annotations are the only things that have nested blocks so we call the blade to render the HTML --}}
{!! $renderData->renderChildren('annotation_block_blocks') !!}
