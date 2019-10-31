@php
    $model_url = $block->input('model_url');
    $model_id = $block->input('model_id');
    $camera_position = $block->input('camera_position');
    $camera_target = $block->input('camera_target');
    $annotation_list = $block->input('annotation_list');
@endphp

@if ($model_url)
    <div class="m-media m-media--l m-media--3d-tour o-blocks__block">
        @component('components.molecules._m-viewer-3d')
            @slot('type', 'article')
            @slot('uid', $model_id)
            @slot('annotations', $annotation_list)
        @endcomponent
    </div>
@endif

<!--<div>
    <h1>3D TOUR BLOCK</h1>
    <p>{{ $model_url }}</p>
    <p>{{ $model_id }}</p>
    <p>{!! json_encode($camera_position) !!}</p>
    <p>{!! json_encode($camera_target) !!}</p>
    <p>{!! json_encode($annotation_list) !!}</p>
</div>-->