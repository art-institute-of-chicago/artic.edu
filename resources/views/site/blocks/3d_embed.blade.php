@php
    $model_url = $block->input('model_url');
    $model_id = $block->input('model_id');
    $caption = $block->input('model_caption');
    $thumbnail_url = $block->image('image');
    $guided_tour = $block->input('guided_tour');
    $artwork_id = Arr::first($block->browserIds('artworks'));
    $artwork = \App\Models\Api\Artwork::query()->find($artwork_id);
    $info_url = route('artworks.show', ['artwork' => $artwork]);
    switch($block->input('cc0_override')) {
        case 1:
            $cc0 = true;
            break;
        case 2:
            $cc0 = false;
            break;
        default:
            $cc0 = empty($artwork->copyright_notice) && $artwork->is_public_domain;
            break;
    }
    $camera_position = $block->input('camera_position');
    $camera_target = $block->input('camera_target');
    $annotation_list = $block->input('annotation_list');
@endphp

@if ($model_url)
    <div class="m-media m-media--l m-media--3d-embed o-blocks__block">
        @component('components.molecules._m-viewer-3d')
            @slot('type', 'standalone')
            @slot('uid', $model_id)
            @slot('cc', $cc0)
            @slot('guided', $guided_tour)
            @slot('artwork', $artwork_id ? $artwork : '')
            @slot('annotations', $annotation_list)
            @slot('title', $pageTitle ? $pageTitle.' - Inline 3D' : 'Inline 3D')
        @endcomponent
        @if ($caption)
        <div class="m-media--3d-embed__caption">
            {{ $caption }}
        </div>
        @endif
    </div>
@endif