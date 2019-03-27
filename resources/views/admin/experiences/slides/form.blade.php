@extends('twill::layouts.form', [
    'contentFieldsetLabel' => 'Setting'
    ])

@section('contentFields')
    {{-- @include('admin.experiences.slides._asset_type') --}}

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
                
            <div style="display: none" id="slide_secondary_experience_image">
                @formField('repeater', ['type' => 'slide_secondary_experience_image'])
            </div>
    
            @formField('input', [
                'name' => 'headline',
                'label' => 'Headline'
            ])
        
            @formField('input', [
                'name' => 'caption',
                'label' => 'Caption'
            ])
        
            @formField('radios', [
                'name' => 'position',
                'label' => 'Postion',
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
        
            @formField('repeater', ['type' => 'experience_modal'])
            @formField('repeater', ['type' => 'secondary_experience_modal'])
        @endcomponent

        @component('twill::partials.form.utils._connected_fields', [
            'fieldName' => 'module_type',
            'fieldValues' => 'interstitial',
        ])
            @formField('input', [
                'name' => 'headline',
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

            @formField('repeater', ['type' => 'compare_experience_image'])
            @formField('repeater', ['type' => 'experience_modal'])
        @endcomponent

    </a17-fieldset>
@stop
@push('extra_js')
    <script>
        // check current attributes states and render form
        console.log({!! json_encode($form_fields) !!});
        // Listen store event and update form
        window.vm.$store.subscribe((mutation, state) => {
            if (mutation.type === 'updateFormField' && mutation.payload.name === 'attributes') {
                const form = mutation.payload.value;
                const e = document.getElementById('slide_secondary_experience_image');
                if (form.includes('secondary_image')) {
                    e.style.display = 'block';
                } else {
                    e.style.display = 'none';
                }
            }
        });
    </script>
@endpush