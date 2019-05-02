@formField('radios', [
    'name' => 'asset_type',
    'label' => 'Asset Type',
    'default' => 'standard',
    'inline' => true,
    'options' => [
        [
            'value' => 'standard',
            'label' => 'Standard'
        ],
        [
            'value' => 'seamless',
            'label' => 'Seamless'
        ],
    ]
])
@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'asset_type',
    'fieldValues' => 'standard',
    'renderForBlocks' => false,
    'keepAlive' => true
])
    @foreach(['split', 'fullwidthmedia'] as $moduleType)
        @component('twill::partials.form.utils._connected_fields', [
            'fieldName' => 'module_type',
            'fieldValues' => $moduleType,
            'renderForBlocks' => false,
            'keepAlive' => true,
        ])
            @formField('radios', [
                'name' => $moduleType . '_standard_media_type',
                'label' => 'Media Type',
                'default' => 'type_image',
                'inline' => true,
                'options' => [
                    [
                        'value' => 'type_image',
                        'label' => 'Image'
                    ],
                    [
                        'value' => 'type_video',
                        'label' => 'Video'
                    ],
                ]
            ])
        @endcomponent
    @endforeach
@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'asset_type',
    'fieldValues' => 'seamless',
    'renderForBlocks' => false,
    'keepAlive' => true
])
    @formField('radios', [
        'name' => 'media_type',
        'label' => 'Media Type',
        'default' => 'type_image',
        'inline' => true,
        'options' => [
            [
                'value' => 'type_image',
                'label' => 'Image'
            ],
            [
                'value' => 'type_sequence',
                'label' => 'Sequence'
            ],
        ]
    ])
    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'media_type',
        'fieldValues' => 'type_image',
        'renderForBlocks' => false
    ])
        @formField('medias', [
            'name' => 'image',
            'label' => 'Image',
            'max' => 1,
        ])
    @endcomponent

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'media_type',
        'fieldValues' => 'type_sequence',
        'renderForBlocks' => false
    ])
        @formField('files', [
            'name' => 'sequence_file',
            'label' => 'Sequence zip file',
            'noTranslate' => true,
            'max' => 1,
        ])
        {{-- <component
            v-bind:is="`a17-block-seamless`"
            :name="`seamless`"
            :seamless-asset-data="{{ isset($form_fields['seamless_asset']) ? json_encode($form_fields['seamless_asset']) : "0" }}"
            :hotspotsdata="{{ isset($form_fields['tooltip_hotspots']) ? json_encode($form_fields['tooltip_hotspots']) : '[]' }}">
        </component> --}}
    @endcomponent

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'module_type',
        'fieldValues' => 'compare',
        'renderForBlocks' => false,
    ])
        @formField('input', [
            'name' => 'caption',
            'label' => 'Caption'
        ])
    @endcomponent

    @formField('input', [
        'name' => 'media_title',
        'label' => 'Media Title'
    ])
@endcomponent