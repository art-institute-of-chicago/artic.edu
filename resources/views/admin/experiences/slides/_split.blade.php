@component('twill::partials.form.utils._connected_fields', [
            'fieldName' => 'module_type',
            'fieldValues' => 'split',
            'keepAlive' => true,
        ])
            <div style="display: none" id="headline">
                @formField('input', [
                    'name' => 'headline',
                    'label' => 'Headline'
                ])
            </div>

            @formField('input', [
                'name' => 'split_primary_copy',
                'type' => 'textarea',
                'label' => 'Primary Copy',
                'rows' => 4
            ])

            @component('twill::partials.form.utils._connected_fields', [
                'fieldName' => 'asset_type',
                'fieldValues' => 'standard',
                'keepAlive' => true,
            ])
                @component('twill::partials.form.utils._connected_fields', [
                    'fieldName' => 'split_standard_media_type',
                    'fieldValues' => 'type_image',
                    'keepAlive' => true,
                ])
                    @formField('repeater', ['type' => 'slide_primary_experience_image'])
                @endcomponent
            @endcomponent
                
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