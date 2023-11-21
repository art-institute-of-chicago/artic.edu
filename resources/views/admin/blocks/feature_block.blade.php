@twillBlockTitle('Feature Block')
@twillBlockIcon('image')

@formField('input', [
    'name' => 'feature_heading',
    'label' => 'Heading',
])

@component('twill::partials.form.utils._columns')
    @slot('left')
        @formField('input', [
            'name' => 'browse_label',
            'label' => 'Browse More Label',
        ])
    @endslot
    @slot('right')
        @formField('input', [
            'name' => 'browse_link',
            'label' => 'Browse More Link',
        ])
    @endslot
@endcomponent

@formField('select', [
    'name' => 'feature_type',
    'label' => 'Feature Type',
    'default' => 'custom',
    'options' => [
        [
            'label' => 'Articles',
            'value' => 'articles',
        ],
        [
            'label' => 'Digital Publications',
            'value' => 'digital_publications',
        ],
        [
            'label' => 'Exhibitions',
            'value' => 'exhibitions',
        ],
        [
            'label' => 'Events',
            'value' => 'events',
        ],
        [
            'label' => 'Interactive Features',
            'value' => 'experiences',
        ],
        [
            'label' => 'Highlights',
            'value' => 'highlights',
        ],
        [
            'label' => 'Videos',
            'value' => 'videos',
        ],
    ]
])

@formField('radios', [
    'name' => 'image_ratio',
    'label' => 'Image Ratio',
    'default' => 'square',
    'inline' => true,
    'options' => [
        [
            'value' => 'square',
            'label' => '1:1'
        ],
        [
            'value' => 'landscape',
            'label' => '16:9'
        ],
    ]
])

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'feature_type',
    'fieldValues' => 'articles',
    'renderForBlocks' => true
])

    @formField('select', [
        'name' => 'columns',
        'label' => '# of columns',
        'note' => 'Number of columns selected and items loaded must match',
        'options' => [
            [
                'label' => '2',
                'value' => 2,
            ],
            [
                'label' => '3',
                'value' => 3,
            ],
            [
                'label' => '4',
                'value' => 4,
            ],
        ]
    ])

    @formField('browser', [
        'name' => 'articles',
        'routePrefix' => 'collection.articles_publications',
        'moduleName' => 'articles',
        'max' => 4,
        'label' => 'Articles',
    ])

@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'feature_type',
    'fieldValues' => 'digital_publications',
    'renderForBlocks' => true
])

    @formField('select', [
        'name' => 'columns',
        'label' => '# of columns',
        'note' => 'Number of columns selected and items loaded must match',
        'options' => [
            [
                'label' => '2',
                'value' => 2,
            ],
            [
                'label' => '3',
                'value' => 3,
            ],
            [
                'label' => '4',
                'value' => 4,
            ],
        ]
    ])

    @formField('browser', [
        'name' => 'digitalPublications',
        'routePrefix' => 'collection.articles_publications',
        'moduleName' => 'digitalPublications',
        'max' => 4,
        'label' => 'Digital Publications',
    ])

@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'feature_type',
    'fieldValues' => 'events',
    'renderForBlocks' => true,
])

    @formField('checkbox', [
        'name' => 'override_event',
        'label' => 'Customize Events',
        'inline' => true,
    ])

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'override_event',
        'fieldValues' => true,
        'renderForBlocks' => true,
    ])
        <br/>
        <i>Note: If event date has passed it will not be shown</i>

        @formField('browser', [
            'name' => 'events',
            'routePrefix' => 'exhibitions_events',
            'moduleName' => 'events',
            'label' => 'Events',
            'max' => 20,
        ])

    @endcomponent

@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'feature_type',
    'fieldValues' => 'exhibitions',
    'renderForBlocks' => true,
])

    @formField('select', [
        'name' => 'columns',
        'label' => '# of columns',
        'note' => 'Number of columns selected and items loaded must match',
        'options' => [
            [
                'label' => '2',
                'value' => 2,
            ],
            [
                'label' => '3',
                'value' => 3,
            ],
            [
                'label' => '4',
                'value' => 4,
            ],
        ]
    ])

    @formField('checkbox', [
        'name' => 'override_exhibition',
        'label' => 'Customize Exhibitions',
        'inline' => true,
    ])

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'override_exhibition',
        'fieldValues' => true,
        'renderForBlocks' => true,
    ])

        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'name' => 'exhibitions',
            'moduleName' => 'exhibitions',
            'max' => 4,
            'label' => 'Exhibitions',
        ])

    @endcomponent

@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'feature_type',
    'fieldValues' => 'experiences',
    'renderForBlocks' => true
])

    @formField('select', [
        'name' => 'columns',
        'label' => '# of columns',
        'note' => 'Number of columns selected and items loaded must match',
        'options' => [
            [
                'label' => '2',
                'value' => 2,
            ],
            [
                'label' => '3',
                'value' => 3,
            ],
            [
                'label' => '4',
                'value' => 4,
            ],
        ]
    ])

    @formField('browser', [
        'name' => 'experiences',
        'routePrefix' => 'collection.interactive_features',
        'moduleName' => 'experiences',
        'max' => 4,
        'label' => 'Experiences',
    ])

@endcomponent


@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'feature_type',
    'fieldValues' => 'highlights',
    'renderForBlocks' => true
])

    @formField('select', [
        'name' => 'columns',
        'label' => '# of columns',
        'note' => 'Number of columns selected and items loaded must match',
        'options' => [
            [
                'label' => '2',
                'value' => 2,
            ],
            [
                'label' => '3',
                'value' => 3,
            ],
            [
                'label' => '4',
                'value' => 4,
            ],
        ]
    ])

    @formField('browser', [
        'routePrefix' => 'collection',
        'moduleName' => 'highlights',
        'name' => 'highlights',
        'label' => 'Highlights',
        'max' => 4,
    ])

@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'feature_type',
    'fieldValues' => 'videos',
    'renderForBlocks' => true
])

    @formField('select', [
        'name' => 'columns',
        'label' => '# of columns',
        'note' => 'Number of columns selected and items loaded must match',
        'options' => [
            [
                'label' => '2',
                'value' => 2,
            ],
            [
                'label' => '3',
                'value' => 3,
            ],
            [
                'label' => '4',
                'value' => 4,
            ],
        ]
    ])

    @formField('browser', [
        'name' => 'videos',
        'routePrefix' => 'collection.articles_publications',
        'moduleName' => 'videos',
        'max' => 4,
        'label' => 'Videos',
    ])

@endcomponent
