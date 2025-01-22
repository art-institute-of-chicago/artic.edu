<x-twill::formFieldset id="side_related" title="Sidebar Related">
    <x-twill::browser
        name='sidebar_items'
        label='Sidebar items'
        route-prefix='$routePrefix'
        module-name='$moduleName'
        :max='6'
        :modules="[
            [
                'label' => 'Article',
                'value' => moduleRoute('articles', 'collection.articlesPublications', 'browser', ['is_unlisted' => false]),
            ],
            [
                'label' => 'Highlight',
                'value' => moduleRoute('highlights', 'collection', 'browser'),
            ],
            [
                'label' => 'Event',
                'value' => moduleRoute('events', 'exhibitionsEvents', 'browser'),
            ],
            [
                'label' => 'Exhibition',
                'value' => moduleRoute('exhibitions', 'exhibitionsEvents', 'browser'),
            ],
            [
                'label' => 'Interactive Feature',
                'value' => moduleRoute('experiences', 'collection.interactiveFeatures', 'browser'),
            ],
            [
                'label' => 'Digital Publication',
                'value' => moduleRoute('digitalPublications', 'collection.articlesPublications', 'browser'),
            ],
            [
                'label' => 'Digital Publication Article',
                'value' => moduleRoute('digitalPublications.articles', 'collection.articlesPublications', 'browserbrowser'),
            ],
            [
                'label' => 'Video',
                'value' => moduleRoute('videos', 'collection.articlesPublications', 'browser'),
            ],
        ]"
    />

    <x-twill::checkbox
        name='toggle_autorelated'
        label='Suppress auto-related items'
        default='false'
    />

    <br>

    <x-twill::formConnectedFields
        field-name='toggle_autorelated'
        field-values="false"
        :render-for-blocks='false'
    >

        @if(count($autoRelated) > 0)
            <p>These items are automatically related and will fill the sidebar along with any of the above selected items.</p>

            <ol style="margin: 1em 0; padding-left: 40px">
                @foreach($autoRelated as $related)
                    <li style="list-style-type: decimal; margin-bottom: 0.5em">
                        {!! Str::title($related->present()->articleType) . (Str::title($related->present()->articleType) ? ":" : "") !!} <a href="{{$related->admin_edit_url}}">{{ $related->title }}</a>
                    </li>
                @endforeach
            </ol>
        @endif

    </x-twill::formConnectedFields>
</x-twill::formFieldset>
