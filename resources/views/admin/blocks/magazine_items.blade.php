@formField('wysiwyg', [
    'name' => 'list_description',
    'label' => 'List description',
    'maxlength' => 255,
    'note' => 'Max 255 characters',
    'toolbarOptions' => [
        'italic'
    ],
])

@formField('radios', [
    'name' => 'feature_type',
    'label' => 'Feature type',
    'default' => 'articles',
    'inline' => true,
    'options' => [
        [
            'value' => 'articles',
            'label' => 'Article'
        ],
        [
            'value' => 'selections',
            'label' => 'Highlights'
        ],
        [
            'value' => 'experiences',
            'label' => 'Interactive Features'
        ],
        [
            'value' => 'custom',
            'label' => 'Custom'
        ],
    ]
])

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'feature_type',
    'fieldValues' => 'articles',
    'renderForBlocks' => true
])
    @formField('browser', [
        'routePrefix' => 'collection.articles_publications',
        'moduleName' => 'articles',
        'name' => 'articles',
        'label' => 'Article'
    ])
@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'feature_type',
    'fieldValues' => 'selections',
    'renderForBlocks' => true
])
    @formField('browser', [
        'routePrefix' => 'collection',
        'moduleName' => 'selections',
        'name' => 'selections',
        'label' => 'Highlight'
    ])
@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'feature_type',
    'fieldValues' => 'experiences',
    'renderForBlocks' => true
])
    @formField('browser', [
        'routePrefix' => 'collection.interactive_features',
        'moduleName' => 'experiences',
        'name' => 'experiences',
        'label' => 'Interactive Feature'
    ])
@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'feature_type',
    'fieldValues' => 'custom',
    'renderForBlocks' => true
])
    @formField('input', [
        'name' => 'tag',
        'label' => 'Tag',
        'note' => 'Small text, eg "Exhibition"'
    ])

    @formField('input', [
        'name' => 'description',
        'label' => 'Description',
    ])

    @formField('input', [
        'name' => 'call_to_action',
        'label' => 'Call to action',
    ])

    @formField('input', [
        'name' => 'url',
        'label' => 'URL for link'
    ])
@endcomponent
