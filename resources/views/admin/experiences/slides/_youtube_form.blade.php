@formField('input', [
    'name' => isset($moduleType) && $moduleType === 'split' ? 'split_youtube_url' : 'youtube_url',
    'label' => 'Youtube URL'
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
            'value' => 'controls_dark',
            'label' => 'Controls Dark'
        ],
        [
            'value' => 'controls_light',
            'label' => 'Controls Light'
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