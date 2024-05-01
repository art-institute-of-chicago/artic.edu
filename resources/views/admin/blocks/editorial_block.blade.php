@php
    $currentUrl = explode('/', request()->url());
    $type = in_array('landingPages', $currentUrl) ? \App\Models\LandingPage::find(intval($currentUrl[5]))->type : null;
    $categoriesList = \App\Models\Category::all()->pluck('name', 'id')->toArray();
    $endpoints = [
        [
            'label' => 'Article',
            'value' => moduleRoute('articles', 'collection.articles_publications', 'browser', ['published' => true]),
        ],
        [
            'label' => 'Highlight',
            'value' => moduleRoute('highlights', 'collection', 'browser', ['is_published' => true])
        ],
        [
            'label' => 'Interactive feature',
            'value' => moduleRoute('experiences', 'collection.interactive_features', 'browser', ['is_published' => true])
        ],
        [
            'label' => 'Video',
            'value' => moduleRoute('videos', 'collection.articles_publications', 'browser', ['is_published' => true]),
        ],
    ];

    switch ($type) {
        case 'Editorial':
            $themes = ['default'];
            break;
        default:
            $themes = ['default'];
    }
@endphp

@twillBlockTitle('Editorial Block')
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
        'fieldValues' => 'default',
        'renderForBlocks' => true,
    ])

        @formField('select', [
            'name' => 'variation',
            'label' => 'Variation',
            'options' => [
                [
                    'value' => 'feature-5-side',
                    'label' => 'Feature 5 Side',
                ],
                [
                    'value' => 'feature-5-top',
                    'label' => 'Feature 5 Top',
                ],
                [
                    'value' => 'video',
                    'label' => 'Video',
                ],
                [
                    'value' => '3-across',
                    'label' => '3 Across',
                ],
                [
                    'value' => '4-across',
                    'label' => '4 Across',
                ],
            ]
        ])
    
    @endcomponent

    @formField('input', [
        'name' => 'heading',
        'label' => 'Heading',
        'type' => 'text',
        'maxlength' => 100,
        'required' => true,
    ])

    @formField('wysiwyg', [
        'name' => 'body',
        'label' => 'Body',
        'required' => true,
        'type' => 'textarea',
    ])

    @formConnectedFields([
        'fieldName' => 'variation',
        'fieldValues' => ['feature-5-side', 'feature-5-top', '3-across', '4-across'],
        'renderForBlocks' => true,
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
        'placeholder' => 'Add categories',
    ])

    @endcomponent

    @formConnectedFields([
        'fieldName' => 'variation',
        'fieldValues' => ['feature-5-side', 'feature-5-top'],
        'renderForBlocks' => true,
    ])

        @formField('browser', [
            'routePrefix' => 'collection.articles_publications',
            'moduleName' => 'articles',
            'name' => 'stories',
            'endpoints' => $endpoints,
            'max' => 5,
            'label' => 'Stories',
        ])
    @endcomponent


    @formConnectedFields([
        'fieldName' => 'variation',
        'fieldValues' => 'video',
        'renderForBlocks' => true,
    ])

        @component('twill::partials.form.utils._columns')
        @slot('left')
            @formField('input', [
                'name' => 'browse_label',
                'label' => 'Browse More Label',
                'type' => 'text',
            ])
        @endslot
        @slot('right')
            @formField('input', [
                'name' => 'browse_link',
                'label' => 'Browse More Link',
                'type' => 'text',
            ])
        @endslot
        @endcomponent

        @formField('browser', [
            'routePrefix' => 'collection.articles_publications',
            'moduleName' => 'articles',
            'name' => 'videos',
            'endpoints' => [
                [
                    'label' => 'Video',
                    'value' => moduleRoute('videos', 'collection.articles_publications', 'browser', ['is_published' => true]),
                ],
            ],
            'max' => 6,
            'label' => 'Videos',
        ])
    @endcomponent

    @formConnectedFields([
        'fieldName' => 'variation',
        'fieldValues' => '3-across',
        'renderForBlocks' => true,
    ])

        @formField('browser', [
            'routePrefix' => 'collection.articles_publications',
            'moduleName' => 'articles',
            'name' => 'stories',
            'endpoints' => $endpoints,
            'max' => 6,
            'label' => 'Stories',
        ])
    @endcomponent

    @formConnectedFields([
        'fieldName' => 'variation',
        'fieldValues' => '4-across',
        'renderForBlocks' => true,
    ])

        @component('twill::partials.form.utils._columns')
        @slot('left')
            @formField('input', [
                'name' => 'browse_label',
                'label' => 'Browse More Label',
                'type' => 'text',
            ])
        @endslot
        @slot('right')
            @formField('input', [
                'name' => 'browse_link',
                'label' => 'Browse More Link',
                'type' => 'text',
            ])
        @endslot
        @endcomponent

        @formField('browser', [
            'routePrefix' => 'collection.articles_publications',
            'moduleName' => 'articles',
            'name' => 'stories',
            'endpoints' => $endpoints,
            'max' => 4,
            'label' => 'Stories',
        ])
    @endcomponent
