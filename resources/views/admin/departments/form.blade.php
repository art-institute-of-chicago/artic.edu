@extends('twill::layouts.form')

@section('contentFields')

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Hero Image',
        'name' => 'hero',
        'note' => 'Minimum image width 2000px'
    ])

    @formField('input', [
        'name' => 'caption',
        'label' => 'Caption',
        'maxlength' => 255
    ])

    @formField('wysiwyg', [
        'name' => 'intro',
        'label' => 'Intro',
    ])

    @formField('input', [
        'name' => 'datahub_id',
        'label' => 'Datahub ID',
        'disabled' => true
    ])

@stop

@section('fieldsets')
    <a17-fieldset id="artworks" title="Artworks">

        @formField('input', [
            'name' => 'pinboard_title',
            'label' => 'Artwork Pinboard Title',
            'note' => 'Defaults to "Artworks" if empty',
        ])

        <p>Use the field below to control which artworks are displayed on the page. The order specified here will be preserved. If there are no artworks selected here, we will filter artworks from CITI by departmental publish category and order the results by relevance.</p>

        @php
            $maxArtworks = \App\Http\Controllers\DepartmentController::ARTWORKS_PER_PAGE;
        @endphp

        @formField('browser', [
            'routePrefix' => 'collection',
            'moduleName' => 'artworks',
            'name' => 'customRelatedArtworks',
            'label' => 'Artworks',
            'max' => $maxArtworks,
        ])

        <p style="margin-top: 2em">You may select up to {{ $maxArtworks }} artworks, but you don't have to max out that number. If you select fewer than {{ $maxArtworks }} artworks, there are two options. First, we can do nothing and display only the artworks you select. Secondly, we can append artworks from CITI as described above, filtered by departmental category and ordered by relevance. Any artworks you select will be filtered out to prevent duplication. This second option is enabled by default to allow departments more time to select artworks to feature.</p>

        @formField('checkbox', [
            'name' => 'should_append_artworks',
            'label' => 'Automatically append artworks from CITI to this list',
            'default' => true,
        ])

        @component('twill::partials.form.utils._connected_fields', [
            'fieldName' => 'should_append_artworks',
            'renderForBlocks' => false,
            'fieldValues' => true
        ])
            @formField('select', [
                'name' => 'max_artworks',
                'label' => 'Max Artworks',
                'note' => 'Artworks will be appended until this number is reached',
                'default' => $maxArtworks,
                'options' => array_map(function($i) {
                    return [
                        'value' => $i,
                        'label' => $i,
                    ];
                }, array_reverse(range(12, $maxArtworks))),
            ])
        @endcomponent

    </a17-fieldset>

    <a17-fieldset id="related" title="Related">

        <p>Use "Custom related items" to relate as many items as possible. No more than 12 will be shown on the department's detail page, but all of them will be used to augment search. See special note on exhibitions below.</p>

        @formField('browser', [
            'name' => 'related_items',
            'endpoints' => [
                [
                    'label' => 'Articles',
                    'value' => '/collection/articles_publications/articles/browser'
                ],
                [
                    'label' => 'Digital Publications',
                    'value' => '/collection/articles_publications/digitalPublications/browser'
                ],
                [
                    'label' => 'Print Publications',
                    'value' => '/collection/articles_publications/printedPublications/browser'
                ],
                [
                    'label' => 'Educational Resources',
                    'value' => '/collection/research_resources/educatorResources/browser'
                ],
                [
                    'label' => 'Interactive Features',
                    'value' => '/collection/digitalLabels/browser'
                ],
                [
                    'label' => 'Videos',
                    'value' => '/collection/articles_publications/videos/browser'
                ],
                [
                    'label' => 'Exhibitions',
                    'value' => '/exhibitions_events/exhibitions/browser'
                ],
            ],
            'max' => 1000,
            'label' => 'Custom related items',
        ])

        <p style="margin-top: 2em;">At this time, we are unable to use CITI data to determine which exhibitions are related to each department, so we cannot automatically add them to department pages. Feel free to relate historic exhibitions here.</p>

    </a17-fieldset>

    @include('admin.partials.meta')

@endsection
