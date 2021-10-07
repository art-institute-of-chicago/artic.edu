@php
    $model_url = $block->input('model_url');
    $model_id = $block->input('model_id');
    $caption_title = $block->input('model_caption_title');
    $caption = $block->input('model_caption');
    $thumbnail_url = $block->image('image');
    $guided_tour = $block->input('guided_tour');
    switch($block->input('cc0_override')) {
        case 1:
            $cc0 = true;
            break;
        case 2:
            $cc0 = false;
            break;
        default:
            $cc0 = false;
            break;
    }
    $camera_position = $block->input('camera_position');
    $camera_target = $block->input('camera_target');
    $annotation_list = $block->input('annotation_list');
@endphp

@if ($model_url)
    @component('components.molecules._m-media')
        @slot('variation', 'o-blocks__block')
        @slot('item', [
            'type' => 'module3d',
            'size' => 's',
            'restricted' => !$cc0,
            'fullscreen' => true,
            'media' => [
                'module3d' => '',
                'model_id' => $model_id,
                'annotation_list' => $annotation_list,
                'cc' => $cc0,
                'guided' => $guided_tour,
                'title' => $pageTitle
            ],
            'poster' => [
                'src' => $thumbnail_url
            ],
            'caption' => $caption,
            'captionTitle' => $caption_title
        ])
    @endcomponent
@endif
