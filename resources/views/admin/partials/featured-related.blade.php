<a17-fieldset id="side_related" title="Sidebar Related">
    @formField('browser', [
        'routePrefix' => $routePrefix,
        'moduleName' => $moduleName,
        'name' => 'sidebar_items',
        'label' => 'Sidebar items',
        'max' => 6,
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
</a17-fieldset>
