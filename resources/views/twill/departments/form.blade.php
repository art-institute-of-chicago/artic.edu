@extends('twill::layouts.form')

@section('contentFields')

    <x-twill::medias
        name='hero'
        label='Hero Image'
        note='Minimum image width 2000px'
    />

    <x-twill::input
        name='caption'
        label='Caption'
        :maxlength='255'
    />

    <x-twill::wysiwyg
        name='intro'
        label='Intro'
        :toolbar-options="[ 'italic', 'link', 'strike' ]"
    />

    <x-twill::input
        name='datahub_id'
        label='Datahub ID'
        disabled='true'
    />

@stop

@section('fieldsets')
    <x-twill::formFieldset id="artworks" title="Artworks">

        <x-twill::input
            name='pinboard_title'
            label='Artwork Pinboard Title'
            note='Defaults to "Artworks" if empty'
        />

        <p>Use the field below to control which artworks are displayed on the page. The order specified here will be preserved. If there are no artworks selected here, we will filter artworks from CITI by departmental publish category and order the results by relevance.</p>

        @php
            $maxArtworks = \App\Http\Controllers\DepartmentController::ARTWORKS_PER_PAGE;
        @endphp

        <x-twill::browser
            name='customRelatedArtworks'
            label='Artworks'
            route-prefix='collection'
            module-name='artworks'
            :max='$maxArtworks'
        />

        <p style="margin-top: 2em">You may select up to {{ $maxArtworks }} artworks, but you don't have to max out that number. If you select fewer than {{ $maxArtworks }} artworks, there are two options. First, we can do nothing and display only the artworks you select. Secondly, we can append artworks from CITI as described above, filtered by departmental category and ordered by relevance. Any artworks you select will be filtered out to prevent duplication. This second option is enabled by default to allow departments more time to select artworks to feature.</p>

        <x-twill::checkbox
            name='should_append_artworks'
            label='Automatically append artworks from CITI to this list'
            default='true'
        />

        <x-twill::formConnectedFields
            field-name='should_append_artworks'
            field-values='true'
            :render-for-blocks='false'
        >

            @php
                $options = array_map(function($i) {
                            return [
                                'value' => $i,
                                'label' => $i,
                            ];
                        }, array_reverse(range(12, $maxArtworks)))
            @endphp

            <x-twill::select
                name='max_artworks'
                label='Max Artworks'
                note='Artworks will be appended until this number is reached'
                default="$maxArtworks"
                :options="$options"
            />
        </x-twill::formConnectedFields>

    </x-twill::formFieldset>

    <x-twill::formFieldset id="related" title="Related">

        <p>Use "Custom related items" to relate as many items as possible. No more than 12 will be shown on the department's detail page, but all of them will be used to augment search. See special note on exhibitions below.</p>

        <x-twill::browser
            name='related_items'
            label='Custom related items'
            :max='1000'
            :modules="[
                [
                    'label' => 'Articles',
                    'value' => '/collection/articlesPublications/articles/browser'
                ],
                [
                    'label' => 'Digital Publications',
                    'value' => '/collection/articlesPublications/digitalPublications/browser'
                ],
                [
                    'label' => 'Print Publications',
                    'value' => '/collection/articlesPublications/printedPublications/browser'
                ],
                [
                    'label' => 'Educational Resources',
                    'value' => '/collection/researchResources/educatorResources/browser'
                ],
                [
                    'label' => 'Interactive Features',
                    'value' => '/collection/interactiveFeatures/experiences/browser'
                ],
                [
                    'label' => 'Videos',
                    'value' => '/collection/articlesPublications/videos/browser'
                ],
                [
                    'label' => 'Exhibitions',
                    'value' => '/exhibitionsEvents/exhibitions/browser'
                ],
            ]"
        />

        <p style="margin-top: 2em;">At this time, we are unable to use CITI data to determine which exhibitions are related to each department, so we cannot automatically add them to department pages. Feel free to relate historic exhibitions here.</p>

    </x-twill::formFieldset>

    @include('twill.partials.meta')

@endsection
