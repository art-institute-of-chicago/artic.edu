@formField('select', [
    'name' => 'modal_type',
    'label' => 'Modal Type',
    'placeholder' => 'Choose Modal Type',
    'default' => 'image',
    'options' => [
        [
            'value' => 'image',
            'label' => 'Image'
        ],
        [
            'value' => 'video',
            'label' => 'Video'
        ],
        [
            'value' => 'image_sequence',
            'label' => 'Image Sequence'
        ]
    ]
])

@component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'modal_type',
        'fieldValues' => 'image',
        'renderForBlocks' => true
])
    @formField('checkbox', [
        'name' => 'zoomable',
        'label' => 'Zoomable'
    ])

    @formField('repeater', ['type' => 'slide_primary_experience_image'])
@endcomponent

@component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'modal_type',
        'fieldValues' => 'video',
        'renderForBlocks' => true
])
    @formField('files', [
        'name' => 'video_file',
        'label' => 'Video',
    ])

    @formField('multi_select', [
        'name' => 'video_play_settings',
        'label' => 'Video Player Setting',
        'min' => 1,
        'max' => 3,
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
            ]
        ]
    ])

    @formField('multi_select', [
        'name' => 'playback',
        'label' => 'playback',
        'options' => [
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
@endcomponent

@component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'modal_type',
        'fieldValues' => 'image_sequence',
        'renderForBlocks' => true
])
    @formField('files', [
        'name' => 'image_sequence_file',
        'label' => 'Image Sequence Zip',
        'note' => 'Upload a .zip file'
    ])

    @formField('multi_select', [
        'name' => 'playback',
        'label' => 'playback',
        'options' => [
            [
                'value' => 'reverse',
                'label' => 'Reverse'
            ],
            [
                'value' => 'infinite',
                'label' => 'Infinite'
            ]
        ]
    ])

    @formField('input', [
        'name' => 'caption',
        'label' => 'Caption'
    ])
@endcomponent