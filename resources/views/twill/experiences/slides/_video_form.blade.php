@formField('input', [
    'name' => isset($moduleType) && $moduleType === 'split' ? 'split_video_url' : 'video_url',
    'label' => 'Vimeo URL'
])

@formField('multi_select', [
    'name' => isset($moduleType) && $moduleType === 'split' ? 'split_video_play_settings' : 'video_play_settings',
    'label' => 'Video Player Setting',
    'default' => 'autoplay',
    'options' => [
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
    ]
])