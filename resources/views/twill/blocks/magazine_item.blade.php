@twillBlockTitle('Magazine Item')
@twillBlockIcon('text')

@formField('radios', [
    'name' => 'feature_type',
    'label' => 'Feature type',
    'default' => \App\Models\MagazineItem::ITEM_TYPE_ARTICLE,
    'inline' => true,
    'options' => [
        [
            'value' => \App\Models\MagazineItem::ITEM_TYPE_ARTICLE,
            'label' => 'Article'
        ],
        [
            'value' => \App\Models\MagazineItem::ITEM_TYPE_HIGHLIGHT,
            'label' => 'Highlights'
        ],
        [
            'value' => \App\Models\MagazineItem::ITEM_TYPE_EXPERIENCE,
            'label' => 'Interactive Features'
        ],
        [
            'value' => \App\Models\MagazineItem::ITEM_TYPE_CUSTOM,
            'label' => 'Custom'
        ],
    ]
])

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'feature_type',
    'fieldValues' => \App\Models\MagazineItem::ITEM_TYPE_ARTICLE,
    'renderForBlocks' => true
])
    @formField('browser', [
        'routePrefix' => 'collection.articles_publications',
        'moduleName' => 'articles',
        'name' => \App\Models\MagazineItem::ITEM_TYPE_ARTICLE,
        'label' => 'Article'
    ])
@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'feature_type',
    'fieldValues' => \App\Models\MagazineItem::ITEM_TYPE_HIGHLIGHT,
    'renderForBlocks' => true
])
    @formField('browser', [
        'routePrefix' => 'collection',
        'moduleName' => 'highlights',
        'name' => \App\Models\MagazineItem::ITEM_TYPE_HIGHLIGHT,
        'label' => 'Highlight'
    ])
@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'feature_type',
    'fieldValues' => \App\Models\MagazineItem::ITEM_TYPE_EXPERIENCE,
    'renderForBlocks' => true
])
    @formField('browser', [
        'routePrefix' => 'collection.interactive_features',
        'moduleName' => 'experiences',
        'name' => \App\Models\MagazineItem::ITEM_TYPE_EXPERIENCE,
        'label' => 'Interactive Feature'
    ])
@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'feature_type',
    'fieldValues' => \App\Models\MagazineItem::ITEM_TYPE_CUSTOM,
    'renderForBlocks' => true
])
    @formField('medias', [
        'name' => 'listing_image',
        'label' => 'Hero image',
    ])

    @formField('input', [
        'name' => 'tag',
        'label' => 'Tag',
        'note' => 'Small text, e.g. "Exhibition"'
    ])

    @formField('input', [
        'name' => 'title',
        'label' => 'Title',
        'note' => 'Use <i> tag to add italics, e.g. <i>Nighthawks</i>'
    ])

    @formField('input', [
        'name' => 'url',
        'label' => 'URL for link'
    ])

    @formField('input', [
        'name' => 'author_display',
        'label' => 'Author'
    ])
@endcomponent

@formField('wysiwyg', [
    'name' => 'list_description',
    'label' => 'List description',
    'maxlength' => 255,
    'note' => 'Max 255 characters',
    'toolbarOptions' => [
        'italic'
    ],
])
