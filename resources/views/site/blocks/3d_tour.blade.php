@php
    $model_url = $block->input('model_url');
    $model_id = $block->input('model_id');
    $camera_position = $block->input('camera_position');
    $camera_target = $block->input('camera_target');
    $annotation_list = $block->input('annotation_list');
    $hide_annotation = $block->input('hide_annotation');
@endphp

@if ($model_url)
    <div class="m-media m-media--l m-media--3d-tour o-blocks__block" data-behavior="fixedOnScroll">
        @component('components.molecules._m-viewer-3d')
            @slot('type', 'article')
            @slot('uid', $model_id)
            @slot('annotations', $annotation_list)
            @slot('hideannot', $hide_annotation)
        @endcomponent
    </div>
@endif