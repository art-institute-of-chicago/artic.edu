@extends('twill::layouts.form', [
    'contentFieldsetLabel' => 'Setting'
    ])

@section('contentFields')
    @include('admin.experiences.slides._asset_type')

    @unless($item->module_type === 'attract' || $item->module_type === 'end')
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
                    'value' => 'fullwidthmedia',
                    'label' => 'Full-Width Media'
                ],
                [
                    'value' => 'compare',
                    'label' => 'Compare'
                ],
            ]
        ])
    @endunless

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'module_type',
        'fieldValues' => 'split',
        'keepAlive' => true,
    ])
        @formField('multi_select', [
            'name' => 'split_attributes',
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
        @if($item->module_type === 'attract')
            @formField('input', [
                'name' => 'headline',
                'label' => 'Headline'
            ])
        
            @formField('input', [
                'name' => 'attract_subhead',
                'label' => 'Subhead'
            ])
            
            @formField('repeater', ['type' => 'attract_experience_image'])
        @endif

        @if($item->module_type === 'end')
            @formField('input', [
                'name' => 'headline',
                'label' => 'Headline'
            ])
        
            @formField('input', [
                'name' => 'end_copy',
                'label' => 'Copy',
                'placeholder' => 'The End',
            ])
        
            @formField('repeater', ['type' => 'end_bg_experience_image'])
        
            <br />
        
            <a17-fieldset title="Credit" id="end" :open="true">
                @formField('input', [
                    'name' => 'end_credit_subhead',
                    'label' => 'Subhead'
                ])
        
                @formField('input', [
                    'name' => 'end_credit_copy',
                    'label' => 'Copy'
                ])
        
                @formField('repeater', ['type' => 'end_experience_image'])
            </a17-fieldset>
        @endif

        @component('twill::partials.form.utils._connected_fields', [
            'fieldName' => 'module_type',
            'fieldValues' => 'split',
            'keepAlive' => true,
        ])
            @formField('input', [
                'name' => 'split_primary_copy',
                'type' => 'textarea',
                'label' => 'Primary Copy',
                'rows' => 4
            ])

            @formField('repeater', ['type' => 'slide_primary_experience_image'])
                
            @formField('radios', [
                'name' => 'image_side',
                'label' => 'Primary Image Side',
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
                @formField('wysiwyg', [
                    'name' => 'caption',
                    'label' => 'Caption',
                    'maxlength' => 500,
                ])
            </div>
        
        
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
            'keepAlive' => true,
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
            'fieldValues' => 'fullwidthmedia',
            'keepAlive' => true,
        ])
            @formField('repeater', ['type' => 'experience_image'])
            @formField('repeater', ['type' => 'experience_modal'])
            @formField('wysiwyg', [
                'name' => 'caption',
                'label' => 'Caption',
                'maxlength' => 500,
            ])
            @formField('checkbox', [
                'name' => 'fullwidth_inset',
                'label' => 'Inset',
            ])
        @endcomponent

        @component('twill::partials.form.utils._connected_fields', [
            'fieldName' => 'module_type',
            'fieldValues' => 'tooltip',
        ])
            @formField('input', [
                'name' => 'object_title',
                'label' => 'Object Title',
                ])
            @formField('wysiwyg', [
                'name' => 'caption',
                'label' => 'Caption',
                'maxlength' => 500,
                ])
            @component('twill::partials.form.utils._connected_fields', [
                'fieldName' => 'asset_type',
                'fieldValues' => 'standard',
            ])
                @formField('repeater', ['type' => 'tooltip_experience_image'])
                <component v-bind:is="`a17-block-tooltip`" :name="`tooltip`" :hotspotsdata="{{ isset($form_fields['tooptip_hotspots']) ? $form_fields['tooltip_hotspots'] : '[]' }}"></component>
            @endcomponent
        @endcomponent

        @component('twill::partials.form.utils._connected_fields', [
            'fieldName' => 'module_type',
            'fieldValues' => 'compare',
            'keepAlive' => true,
        ])
            @formField('input', [
                'name' => 'compare_title',
                'label' => 'Title'
            ])

            @formField('repeater', ['type' => 'compare_experience_image_1'])
            @formField('repeater', ['type' => 'compare_experience_image_2'])
            @formField('repeater', ['type' => 'compare_experience_modal'])
        @endcomponent

    </a17-fieldset>
@stop
@push('extra_js')
    <script>
        const attributesField = window.STORE.form.fields.find(field => field.name == 'split_attributes');
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
                const attributes = newVal.find(field => field.name == 'split_attributes');
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