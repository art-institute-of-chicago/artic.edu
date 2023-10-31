@twillBlockTitle('Stories Block')
@twillBlockIcon('Image')

@formField('input', [
    'name' => 'stories_heading',
    'label' => 'Heading'
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

@formField('browser', [
    'name' => 'content',
    'label' => 'Stories',
    'max' => 5,
    'endpoints' => [
        [
            'label' => 'Article',
            'value' => moduleRoute('articles', 'collection.articles_publications', 'browser', ['is_unlisted' => false]),
        ],
        [
            'label' => 'Highlight',
            'value' => moduleRoute('highlights', 'collection', 'browser'),
        ],
        [
            'label' => 'Event',
            'value' => moduleRoute('events', 'exhibitions_events', 'browser'),
        ],
        [
            'label' => 'Exhibition',
            'value' => moduleRoute('exhibitions', 'exhibitions_events', 'browser'),
        ],
        [
            'label' => 'Interactive Feature',
            'value' => moduleRoute('experiences', 'collection.interactive_features', 'browser'),
        ],
        [
            'label' => 'Digital Publication',
            'value' => moduleRoute('digitalPublications', 'collection.articles_publications', 'browser'),
        ],
        [
            'label' => 'Video',
            'value' => moduleRoute('videos', 'collection.articles_publications', 'browser'),
        ],
    ],
])

