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
                'name' => 'collection.articlesPublications.articles'
            ],
            [
                'label' => 'Highlight',
                'name' => 'collection.highlights'
            ],
            [
                'label' => 'Event',
                'name' => 'exhibitionsEvents.events'
            ],
            [
                'label' => 'Exhibition',
                'name' => 'exhibitionsEvents.exhibitions'
            ],
            [
                'label' => 'Interactive Feature',
                'name' => 'collection.interactiveFeatures.experiences'
            ],
            [
                'label' => 'Digital Publication',
                'name' => 'collection.articlesPublication.digitalPublications'
            ],
            [
                'label' => 'Digital Publication Article',
                'name' => 'collection.articlesPublications.digitalPublications.articles.browserbrowser'
            ],
            [
                'label' => 'Video',
                'name' => 'collection.articlesPublications.videos'
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
