<a17-fieldset id="side_related" title="Sidebar Related">
    <p>One of the following items will be randomly selected and shown in the right sidebar.</p>

    <hr style="margin-top: 35px"/>

    @php
        $endpoints = [];

        if (isset($articles)) {
            array_push($endpoints, [
                'label' => 'Article',
                'value' => moduleRoute('articles', 'collection.articles_publications', 'browser')
            ]);
        }

        if (isset($events)) {
            array_push($endpoints, [
                'label' => 'Event',
                'value' => moduleRoute('events', 'exhibitions_events', 'browser')
            ]);
        }

        if (isset($exhibitions)) {
            array_push($endpoints, [
                'label' => 'Exhibition',
                'value' => moduleRoute('exhibitions', 'exhibitions_events', 'browser')
            ]);
        }

        if (isset($experiences)) {
            array_push($endpoints, [
                'label' => 'Interactive feature',
                'value' => moduleRoute('interactiveFeatures.experiences', 'collection', 'browser')
            ]);
        }

        if (isset($videos)) {
            array_push($endpoints, [
                'label' => 'Video',
                'value' => moduleRoute('videos', 'collection.articles_publications', 'browser')
            ]);
        }
    @endphp

    @formField('browser', [
        'routePrefix' => $routePrefix,
        'moduleName' => $moduleName,
        'name' => 'sidebar_items',
        'endpoints' => $endpoints,
        'max' => 4,
        'label' => 'Sidebar items',
    ])
</a17-fieldset>
