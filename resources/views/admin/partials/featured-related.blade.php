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

    @formField('checkbox', [
        'name' => 'toggle_autorelated',
        'label' => 'Suppress auto-related items',
        'default' => false,
    ])

    <br>

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'toggle_autorelated',
        'fieldValues' => false,
        'renderForBlocks' => false
    ])

        @if(count($autoRelated) > 0)
            <p>These items are automatically related and will fill the sidebar along with any of the above selected items.</p>

            <ol style="margin: 1em 0; padding-left: 40px">
                @foreach($autoRelated as $related)
                    <li style="list-style-type: decimal; margin-bottom: 0.5em">
                        {!! Str::title($related->type) . (Str::title($related->type) ? ":" : "") !!} <a href="{{$related->admin_edit_url}}">{{ $related->title }}</a>
                    </li>
                @endforeach
            </ol>
        @endif

    @endcomponent
</a17-fieldset>
