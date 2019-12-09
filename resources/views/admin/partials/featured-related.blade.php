<a17-fieldset id="side_related" title="Sidebar Related">
    <p>One of the following items will be randomly selected and shown in the right sidebar.</p>

    <hr style="margin-top: 35px"/>

    @formField('browser', [
        'routePrefix' => $routePrefix,
        'moduleName' => $moduleName,
        'name' => 'sidebar_items',
        'label' => 'Sidebar items',
        'max' => 10,
        'endpoints' => [
            [
                'label' => 'Article',
                'value' => moduleRoute('articles', 'collection.articles_publications', 'browser'),
            ],
            [
                'label' => 'Highlight',
                'value' => moduleRoute('selections', 'collection', 'browser'),
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
                'value' => moduleRoute('interactiveFeatures.experiences', 'collection', 'browser'),
            ],
            [
                'label' => 'Video',
                'value' => moduleRoute('videos', 'collection.articles_publications', 'browser'),
            ],
        ],

    ])
</a17-fieldset>
