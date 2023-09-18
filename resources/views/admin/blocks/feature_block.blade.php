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
            'label' => 'Custom',
            'value' => 'custom',
        ],
        [
            'label' => 'Event',
            'value' => 'event',
        ],
        [
            'label' => 'Exhibition',
            'value' => 'exhibition',
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
    'fieldValues' => 'custom',
    'renderForBlocks' => true
])

    @formField('select', [
        'name' => 'columns',
        'label' => '# of columns',
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

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'columns',
        'fieldValues' => 2,
        'renderForBlocks' => true
    ])

    @formField('browser', [
        'name' => 'content_type',
        'endpoints' => [
                [
                    'label' => 'Article',
                    'value' => moduleRoute('articles', 'collection.articles_publications', 'browser', ['is_unlisted' => false]),
                ],
                [
                    'label' => 'Highlight',
                    'value' => moduleRoute('highlights', 'collection', 'browser', [], false),
                ],
                [
                    'label' => 'Event',
                    'value' => moduleRoute('events', 'exhibitions_events', 'browser', [], false),
                ],
                [
                    'label' => 'Exhibition',
                    'value' => moduleRoute('exhibitions', 'exhibitions_events', 'browser', [], false),
                ],
                [
                    'label' => 'Interactive Feature',
                    'value' => moduleRoute('experiences', 'collection.interactive_features', 'browser', [], false),
                ],
                [
                    'label' => 'Digital Publication',
                    'value' => moduleRoute('digitalPublications', 'collection.articles_publications', 'browser', [], false),
                ],
                [
                    'label' => 'Video',
                    'value' => moduleRoute('videos', 'collection.articles_publications', 'browser', [], false),
                ],
            ],
        'max' => 2,
        'label' => 'Featured items',
    ])

    @endcomponent

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'columns',
        'fieldValues' => 3,
        'renderForBlocks' => true
    ])

    @formField('browser', [
        'name' => 'content_type',
        'endpoints' => [
                [
                    'label' => 'Article',
                    'value' => moduleRoute('articles', 'collection.articles_publications', 'browser', ['is_unlisted' => false]),
                ],
                [
                    'label' => 'Highlight',
                    'value' => moduleRoute('highlights', 'collection', 'browser', [], false),
                ],
                [
                    'label' => 'Event',
                    'value' => moduleRoute('events', 'exhibitions_events', 'browser', [], false),
                ],
                [
                    'label' => 'Exhibition',
                    'value' => moduleRoute('exhibitions', 'exhibitions_events', 'browser', [], false),
                ],
                [
                    'label' => 'Interactive Feature',
                    'value' => moduleRoute('experiences', 'collection.interactive_features', 'browser', [], false),
                ],
                [
                    'label' => 'Digital Publication',
                    'value' => moduleRoute('digitalPublications', 'collection.articles_publications', 'browser', [], false),
                ],
                [
                    'label' => 'Video',
                    'value' => moduleRoute('videos', 'collection.articles_publications', 'browser', [], false),
                ],
            ],
        'max' => 3,
        'label' => 'Featured items',
    ])

    @endcomponent

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'columns',
        'fieldValues' => 4,
        'renderForBlocks' => true
    ])

    @formField('browser', [
        'name' => 'content_type',
        'endpoints' => [
                [
                    'label' => 'Article',
                    'value' => moduleRoute('articles', 'collection.articles_publications', 'browser', ['is_unlisted' => false]),
                ],
                [
                    'label' => 'Highlight',
                    'value' => moduleRoute('highlights', 'collection', 'browser', [], false),
                ],
                [
                    'label' => 'Event',
                    'value' => moduleRoute('events', 'exhibitions_events', 'browser', [], false),
                ],
                [
                    'label' => 'Exhibition',
                    'value' => moduleRoute('exhibitions', 'exhibitions_events', 'browser', [], false),
                ],
                [
                    'label' => 'Interactive Feature',
                    'value' => moduleRoute('experiences', 'collection.interactive_features', 'browser', [], false),
                ],
                [
                    'label' => 'Digital Publication',
                    'value' => moduleRoute('digitalPublications', 'collection.articles_publications', 'browser', [], false),
                ],
                [
                    'label' => 'Video',
                    'value' => moduleRoute('videos', 'collection.articles_publications', 'browser',[], false),
                ],
            ],
        'max' => 4,
        'label' => 'Featured items',
    ])

    @endcomponent

@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'feature_type',
    'fieldValues' => 'event',
    'renderForBlocks' => true,
])

    @formField('checkbox', [
        'name' => 'override_event',
        'label' => 'Override Events',
        'inline' => true,
    ])

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'override_event',
        'fieldValues' => true,
        'renderForBlocks' => true,
    ])

        @formField('browser', [
            'name' => 'events',
            'endpoints' => [
                    [
                        'label' => 'Event',
                        'value' => moduleRoute('events', 'exhibitions_events', 'browser', [], false)
                    ]
                ],
            'label' => 'Events',
            'max' => 20,
        ])

    @endcomponent

@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'feature_type',
    'fieldValues' => 'exhibition',
    'renderForBlocks' => true,
])

    @formField('checkbox', [
        'name' => 'override_exhibition',
        'label' => 'Override Exhibitions',
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