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
        'renderForBlocks' => true,
        'keepAlive' => true
])
    @formField('checkbox', [
        'name' => 'zoomable',
        'label' => 'Zoomable'
    ])

    @formField('radios', [
        'name' => 'has_experience_image',
        'label' => 'Experience Image',
        'default' => false,
        'inline' => true,
        'options' => [
            [
                'value' => true,
                'label' => 'On'
            ],
            [
                'value' => false,
                'label' => 'Off'
            ]
        ]
    ])
    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'has_experience_image',
        'fieldValues' => true,
        'renderForBlocks' => true
    ])
        @include('admin.blocks.experience_image')
    @endcomponent
@endcomponent

@component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'modal_type',
        'fieldValues' => 'video',
        'renderForBlocks' => true
])
    @formField('input', [
        'name' => 'video_url',
        'label' => 'Youtube URL'
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

    {{-- </br><h3>Video Player Setting</h3>
    @formField('checkbox', [
        'name' => 'autoplay',
        'label' => 'Autoplay'
    ])

    @formField('checkbox', [
        'name' => 'controls_dark',
        'label' => 'Controls Dark'
    ])

    @formField('checkbox', [
        'name' => 'controls_light',
        'label' => 'Controls Light'
    ]) --}}

    @formField('multi_select', [
        'name' => 'video_playback',
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

    {{-- </br><h3>Playback</h3>
    @formField('checkbox', [
        'name' => 'inset',
        'label' => 'Inset'
    ])

    @formField('checkbox', [
        'name' => 'caption',
        'label' => 'Caption'
    ])

    @formField('checkbox', [
        'name' => 'loop',
        'label' => 'Loop'
    ])   --}}
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
        'name' => 'image_sequence_playback',
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
        'name' => 'image_sequence_caption',
        'label' => 'Caption'
    ])
@endcomponent