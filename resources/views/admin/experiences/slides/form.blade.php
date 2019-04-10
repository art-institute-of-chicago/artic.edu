@extends('twill::layouts.form', [
    'contentFieldsetLabel' => 'Setting'
    ])

@section('contentFields')
    @include('admin.experiences.slides._asset_type')

    @formField('select', [
        'name' => 'module_type',
        'required' => true,
        'label' => 'Module Type',
        'placeholder' => 'Select a type',
        'options' => [
            [
                'value' => 'split',
                'label' => 'Split'
            ],
            [
                'value' => 'interstitial',
                'label' => 'Interstitial'
            ],
            [
                'value' => 'tooltip',
                'label' => 'Tooltip'
            ],
            [
                'value' => 'full-width-media',
                'label' => 'Full-Width Media'
            ],
            [
                'value' => 'compare',
                'label' => 'Compare'
            ],
        ]
    ])

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'module_type',
        'fieldValues' => 'split',
    ])
        @formField('multi_select', [
            'name' => 'attributes',
            'label' => 'Attributes',
            'options' => [
                [
                    'value' => 'inset',
                    'label' => 'Inset'
                ],
                [
                    'value' => 'primary_modal',
                    'label' => 'Primary Modal'
                ],
                [
                    'value' => 'headline',
                    'label' => 'Headline'
                ],
                [
                    'value' => 'secondary_image',
                    'label' => 'Secondary Image'
                ],
                [
                    'value' => 'secondary_modal',
                    'label' => 'Secondary Modal'
                ],
                [
                    'value' => 'caption',
                    'label' => 'Caption'
                ],
            ]
        ])
    @endcomponent
@stop

@section('fieldsets')
    <a17-fieldset title="Content" id="content">

        @component('twill::partials.form.utils._connected_fields', [
            'fieldName' => 'module_type',
            'fieldValues' => 'split',
        ])
            @formField('repeater', ['type' => 'slide_primary_experience_image'])
                
            <div style="display: none" id="secondary_image">
                @formField('repeater', ['type' => 'slide_secondary_experience_image'])
            </div>
    
            <div style="display: none" id="headline">
                @formField('input', [
                    'name' => 'headline',
                    'label' => 'Headline'
                ])
            </div>
        
            <div style="display: none" id="caption">
                @formField('input', [
                    'name' => 'caption',
                    'label' => 'Caption'
                ])
            </div>
        
            @formField('radios', [
                'name' => 'image_side',
                'label' => 'Image Side',
                'default' => 'left',
                'inline' => true,
                'options' => [
                    [
                        'value' => 'left',
                        'label' => 'Left'
                    ],
                    [
                        'value' => 'right',
                        'label' => 'Right'
                    ],
                    ]
            ])
        
            <div style="display: none" id="primary_modal">
                @formField('repeater', ['type' => 'primary_experience_modal'])
            </div>
            <div style="display: none" id="secondary_modal">
                @formField('repeater', ['type' => 'secondary_experience_modal'])
            </div>
        @endcomponent

        @component('twill::partials.form.utils._connected_fields', [
            'fieldName' => 'module_type',
            'fieldValues' => 'interstitial',
        ])
            @formField('input', [
                'name' => 'interstitial_headline',
                'label' => 'Headline'
            ])

            @formField('input', [
                'name' => 'body_copy',
                'label' => 'Body Copy'
            ])

            @formField('input', [
                'name' => 'section_title',
                'label' => 'Section Title'
            ])

            @formField('repeater', ['type' => 'experience_image'])
        @endcomponent

        @component('twill::partials.form.utils._connected_fields', [
            'fieldName' => 'module_type',
            'fieldValues' => 'full-width-media',
        ])
            @formField('repeater', ['type' => 'experience_image'])
            @formField('repeater', ['type' => 'experience_modal'])
            @formField('input', [
                'name' => 'caption',
                'label' => 'Caption'
            ])
        @endcomponent

        @component('twill::partials.form.utils._connected_fields', [
            'fieldName' => 'module_type',
            'fieldValues' => 'tooltip',
        ])
            @formField('repeater', ['type' => 'experience_image'])
            @formField('input', [
                'name' => 'object_title',
                'label' => 'Object Title',
            ])
            @formField('input', [
                'name' => 'caption',
                'label' => 'Caption'
            ])
        @endcomponent

        @component('twill::partials.form.utils._connected_fields', [
            'fieldName' => 'module_type',
            'fieldValues' => 'compare',
        ])
            @formField('input', [
                'name' => 'compare_title',
                'label' => 'Title'
            ])

            @formField('repeater', ['type' => 'compare_experience_image_1'])
            @formField('repeater', ['type' => 'compare_experience_image_2'])
            @formField('repeater', ['type' => 'experience_modal'])
        @endcomponent

    </a17-fieldset>
@stop
@push('extra_js')
    <script>
        const attributesField = window.STORE.form.fields.find(field => field.name == 'attributes');
        if (attributesField) {
            attributesField.value.forEach(function (option) {
                const e = document.getElementById(option);
                if (e) {
                    e.style.display = 'block';
                }
            });
        }
        window.vm.$store.watch(
            function (state) {
                return state.form.fields;
            },
            function (newVal, oldVal) {
                const attributes = newVal.find(field => field.name == 'attributes');
                if (attributes) {
                    const options = ['inset', 'primary_modal', 'headline', 'secondary_image', 'secondary_modal', 'caption'];
                    options.forEach(function (option) {
                        const e = document.getElementById(option);
                        if (e) {
                            if (attributes.value.includes(option)) {
                                e.style.display = 'block';
                            } else {
                                e.style.display = 'none';
                            }
                        }
                    });
                }
            }
        )
    </script>
@endpush