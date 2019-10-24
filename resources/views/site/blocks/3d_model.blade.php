@php
    $model_url = $block->input('model_url');
    $model_id = $block->input('model_id');
    $caption = $block->input('model_caption');
    $thumbnail_url = $block->image('image');
    $artwork_id = Arr::first($block->browserIds('artworks'));
    $artwork = \App\Models\Api\Artwork::query()->find($artwork_id);
    $info_url = route('artworks.show', ['artwork' => $artwork]);
    $cc0 = empty($artwork->copyright_notice) && $artwork->is_public_domain;
    $camera_position = $block->input('camera_position');
    $camera_target = $block->input('camera_target');
    $annotation_list = $block->input('annotation_list');
@endphp

<div>
    <h1>3D Model BLOCK</h1>
    <p>{{ $model_url }}</p>
    <p>{{ $model_id }}</p>
    <p>{{ $caption }}</p>
    <p>{{ $thumbnail_url }}</p>
    <p>{{ $info_url }}</p>
    <p>{{ $cc0 }}</p>
    <p>{!! json_encode($camera_position) !!}</p>
    <p>{!! json_encode($camera_target) !!}</p>
    <p>{!! json_encode($annotation_list) !!}</p>
</div>