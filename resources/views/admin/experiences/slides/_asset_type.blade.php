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
            [
                'value' => '3dModel',
                'label' => '3D model'
            ]
        ]
    ])

    @push('extra_js')
    <script>
        const find3dOption = () => {
            return [].slice.call(document.querySelectorAll("input[value='3dModel']")).find(
                el => el.className === 'singleselector__radio'
            )
        }
        const currentModuleType = window.STORE.form.fields.find(field => field.name == 'module_type').value;
        
        if (currentModuleType !== 'fullwidthmedia' && find3dOption()) {
            find3dOption().parentNode.style.display = "none";
        }
        window.vm.$store.watch(
            function (state) {
                return state.form.fields;
            },
            function (newVal, oldVal) {
                const moduleType = newVal.find(field => field.name == 'module_type');
                if(moduleType && find3dOption()) {
                    if (moduleType.value !== 'fullwidthmedia') {
                        find3dOption().parentNode.style.display = "none";
                    } else {
                        find3dOption().parentNode.style.display = "block";
                    }
                }
            })
    </script>
    @endpush

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

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'asset_type',
    'fieldValues' => 'standard',
    'keepAlive' => true,
])
    @foreach(['split', 'fullwidthmedia'] as $moduleType)
        @component('twill::partials.form.utils._connected_fields', [
            'fieldName' => $moduleType . '_standard_media_type',
            'fieldValues' => 'type_video',
            'keepAlive' => true,
        ])
            @component('twill::partials.form.utils._connected_fields', [
                'fieldName' => 'module_type',
                'fieldValues' => $moduleType,
                'renderForBlocks' => false,
                'keepAlive' => true,
            ])
                <br/>
                <a17-fieldset title="Video" id="video">
                    @include('admin.experiences.slides._video_form', ['moduleType' => $moduleType])
                </a17-fieldset>
            @endcomponent
        @endcomponent
    @endforeach
@endcomponent