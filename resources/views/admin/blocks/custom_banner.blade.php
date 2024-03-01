@php
    $currentUrl = explode('/', request()->url());
    $type = in_array('landingPages', $currentUrl) ? \App\Models\LandingPage::find(intval($currentUrl[5]))->type : null;
    $categoriesList = \App\Models\Category::all()->pluck('name', 'id')->toArray();

    switch ($type) {
        case 'Stories':
            $themes = ['default', 'stories'];
            break;
        default:
            $themes = ['default'];
    }
@endphp

@twillBlockTitle('Custom Banner')
@twillBlockIcon('image')

@formField('select', [
    'name' => 'theme',
    'label' => 'Theme',
    'default' => 'default',
    'options' => collect($themes)->map(function($theme) {
        return [
            'value' => $theme,
            'label' => ucfirst($theme),
        ];
    })->toArray(),
])

@formConnectedFields([
    'fieldName' => 'theme',
    'fieldValues' => 'stories',
    'renderForBlocks' => true,
    ])

    @formField('select', [
        'name' => 'variation',
        'label' => 'Variation',
        'options' => [
            [
                'value' => 'cloud',
                'label' => 'Tag cloud',
            ],
        ]
    ])

@endcomponent

    @formConnectedFields([
        'fieldName' => 'variation',
        'fieldValues' => 'cloud',
        'renderForBlocks' => true,
    ])

        @formField('radios', [
            'name' => 'background_type',
            'label' => 'Background Type',
            'default' => 'mobile_app',
            'inline' => true,
            'options' => [
                [
                    'value' => 'background_image',
                    'label' => 'Image'
                ],
                [
                    'value' => 'background_color',
                    'label' => 'Color'
                ],
            ]
        ])

        @component('twill::partials.form.utils._connected_fields', [
            'fieldName' => 'background_type',
            'fieldValues' => 'background_image',
            'renderForBlocks' => true
        ])

            @formField('medias', [
                'name' => 'image',
                'label' => 'Image',
                'max' => 1,
                'withVideoUrl' => false,
                'required' => true,
            ])

        @endcomponent

        @component('twill::partials.form.utils._connected_fields', [
            'fieldName' => 'background_type',
            'fieldValues' => 'background_color',
            'renderForBlocks' => true
        ])

            @formField('color', [
                'name' => 'bgcolor',
                'label' => 'Background color',
                'default' => '#000000'
            ])

        @endcomponent

        @formField('input', [
            'name' => 'title',
            'label' => 'Title',
            'type' => 'text',
            'maxlength' => 100,
            'required' => true,
        ])

        @formField('wysiwyg', [
            'name' => 'body',
            'label' => 'Body',
            'required' => true,
        ])

        @formField('multi_select', [
            'name' => 'categories',
            'label' => 'Categories',
            'options' => collect($categoriesList)->map(function($name, $id) {
                return [
                    'value' => $id,
                    'label' => $name,
                ];
            })->toArray(),
            'placeholder' => 'Add categories to the tag cloud',
        ])

    @endcomponent

@formConnectedFields([
    'fieldName' => 'theme',
    'fieldValues' => 'default',
    'renderForBlocks' => true,
    ])

@formField('radios', [
    'name' => 'background_type',
    'label' => 'Background Type',
    'default' => 'mobile_app',
    'inline' => true,
    'options' => [
        [
            'value' => 'background_image',
            'label' => 'Image'
        ],
        [
            'value' => 'background_color',
            'label' => 'Color'
        ],
    ]
])

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'background_type',
    'fieldValues' => 'background_image',
    'renderForBlocks' => true
])

    @formField('medias', [
        'name' => 'image',
        'label' => 'Image',
        'max' => 1,
        'withVideoUrl' => false,
        'required' => true,
    ])

@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'background_type',
    'fieldValues' => 'background_color',
    'renderForBlocks' => true
])

    @formField('color', [
        'name' => 'bgcolor',
        'label' => 'Background color',
        'default' => '#000000'
    ])

@endcomponent


@formField('input', [
    'name' => 'title',
    'label' => 'Title',
    'type' => 'text',
    'maxlength' => 100,
    'required' => true,
])

@formField('wysiwyg', [
    'name' => 'body',
    'label' => 'Body',
    'required' => true,
])

@formField('radios', [
    'name' => 'button_type',
    'label' => 'Variation',
    'default' => 'mobile_app',
    'inline' => true,
    'options' => [
        [
            'value' => 'mobile_app',
            'label' => 'Mobile App'
        ],
        [
            'value' => 'custom',
            'label' => 'Custom'
        ],
    ]
])

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'button_type',
    'fieldValues' => 'custom',
    'renderForBlocks' => true
])

    @formField('input', [
        'name' => 'button_text',
        'label' => 'Button Text',
        'type' => 'text',
        'maxlength' => 100,
        'required' => true,
    ])

    @formField('input', [
        'name' => 'button_url',
        'label' => 'Button URL',
        'type' => 'text',
        'maxlength' => 100,
        'required' => true,
    ])

@endcomponent

@endcomponent
