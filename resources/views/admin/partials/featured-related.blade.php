<a17-fieldset id="side_related" title="Sidebar Related">
    <p>One of the following items will be randomly selected and shown in the right sidebar.</p>

    <hr style="margin-top: 35px"/>

    @if (isset($articles))
        @formField('browser', [
            'routePrefix' => 'collection.articles_publications',
            'moduleName' => 'articles',
            'max' => 1,
            'name' => $articles ?? 'sidebarArticle',
            'label' => 'Related article',
        ])
    @endif

    @if (isset($events))
        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'moduleName' => 'events',
            'name' => $events ?? 'sidebarEvent',
            'label' => 'Related event',
            'max' => 1
        ])
    @endif

    @if (isset($exhibitions))
        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'moduleName' => 'exhibitions',
            'max' => 1,
            'name' => $exhibitions ?? 'sidebarExhibitions',
            'label' => 'Related exhibition',
        ])
    @endif

    @if (isset($experiences))
        @formField('browser', [
            'routePrefix' => 'collection',
            'moduleName' => 'interactiveFeatures.experiences',
            'max' => 1,
            'name' => $experiences ?? 'sidebarExperiences',
            'label' => 'Related interactive feature',
        ])
    @endif

    @if (isset($videos))
        @formField('browser', [
            'routePrefix' => 'collection.articles_publications',
            'moduleName' => 'videos',
            'max' => 1,
            'name' => $videos ?? 'videos',
            'label' => 'Related video'
        ])
    @endif
</a17-fieldset>
