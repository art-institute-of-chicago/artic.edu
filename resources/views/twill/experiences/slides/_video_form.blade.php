@php
    $name = isset($moduleType) && $moduleType === 'split' ? 'split_video_url' : 'video_url';
@endphp
<x-twill::input
    name='$name'
    label='Vimeo URL'
/>

@php
    $name = isset($moduleType) && $moduleType === 'split' ? 'split_video_play_settings' : 'video_play_settings';
@endphp

<x-twill::multi-select
    name='$name'
    label='Video Player Setting'
    default='autoplay'
    :options="[
        [
            'value' => 'autoplay',
            'label' => 'Autoplay'
        ],
        [
            'value' => 'control',
            'label' => 'Control'
        ],
        [
            'value' => 'inset',
            'label' => 'Inset'
        ],
        [
            'value' => 'caption',
            'label' => 'Caption'
        ],
        [
            'value' => 'loop',
            'label' => 'Loop'
        ]
    ]"
/>
