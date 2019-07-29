@unless(in_array($item->module_type, ['attract', 'end']))
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
@endunless

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
        'renderForBlocks' => false,
        'keepAlive' => true
    ])
        @formField('repeater', ['type' => 'seamless_experience_image'])
        <component
            v-bind:is="`a17-block-seamless`"
            :is-seamless-image="{{ 'true' }}"
            :seamless-asset-data="{{ isset($form_fields['seamless_image_asset']) ? json_encode($form_fields['seamless_image_asset']) : "null" }}"
            :hotspotsdata="{{ isset($form_fields['tooltip_hotspots']) ? json_encode($form_fields['tooltip_hotspots']) : '[]' }}"
            :name="`seamless_image`">
        </component>
    @endcomponent

    <br />
    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'media_type',
        'fieldValues' => 'type_sequence',
        'renderForBlocks' => false,
        'keepAlive' => true
    ])
        <a17-fieldset title="Seamless Sequence" id="seamless-asset">
            @formField('files', [
                'name' => 'sequence_file',
                'label' => 'Sequence zip file',
                'noTranslate' => true,
                'max' => 1,
            ])

            <component
                v-bind:is="`a17-block-seamless`"
                :name="`seamless`"
                :seamless-asset-data="{{ isset($form_fields['seamless_asset']) ? json_encode($form_fields['seamless_asset']) : "null" }}"
                :hotspotsdata="{{ isset($form_fields['tooltip_hotspots']) ? json_encode($form_fields['tooltip_hotspots']) : '[]' }}">
            </component>

            @formField('input', [
                'name' => 'seamless_alt_text',
                'label' => 'Alt Text'
            ])
        </a17-fieldset>
    @endcomponent

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'module_type',
        'fieldValues' => 'compare',
        'renderForBlocks' => false,
    ])
        @formField('wysiwyg', [
            'name' => 'caption',
            'label' => 'Seamless Caption',
            'maxlength' => 500,
        ])
    @endcomponent
@endcomponent