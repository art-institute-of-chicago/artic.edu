@extends('twill::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'datahub_id',
        'label' => 'Datahub ID',
        'disabled' => true
    ])

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Hero Image',
        'name' => 'hero',
        'note' => 'Minimum image width 2000px'
    ])

    @formField('input', [
        'name' => 'caption',
        'label' => 'Caption'
    ])

    @formField('input', [
        'name' => 'birth_date',
        'label' => 'Birth Date',
        'disabled' => true
    ])

    @formField('input', [
        'name' => 'death_date',
        'label' => 'Death Date',
        'disabled' => true
    ])

    @formField('wysiwyg', [
        'name' => 'intro',
        'label' => 'Intro',
    ])
@stop

@section('fieldsets')
    <a17-fieldset id="related" title="Related">

        <p>Use "Custom related items" to relate as many items as possible. No more than 12 will be shown on the artist's detail page, but all of them will be used to augment search. See special note on exhibitions below.</p>

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

        <p>We use CITI data to determine which exhibitions are related to each artist by checking which artworks were featured in each exhibition. We automatically append any exhibition related in this way to the "Related Content" section in reverse chronological order. The following exhibitions would be shown on this artist's page automatically:</p>

        @php
            $apiItem = $item->getApiModelFilled();
            $relatedExhibitions = (new \App\Repositories\Api\ArtistRepository($apiItem))->getApiRelatedItems($apiItem)
        @endphp
        <ol style="margin: 1em 0; padding-left: 40px">
            @foreach($relatedExhibitions as $exhibition)
                <li style="list-style-type: decimal; margin-bottom: 0.5em">
                    <a href="{!! route('exhibitions.show', $exhibition) !!}">{{ $exhibition->title }}</a>
                </li>
            @endforeach
        </ol>

        <p style="margin-top: 1em">If this logic is satisfactory, there's no need to add exhibitions to the "Custom related items" field. However, if you'd like to control the order of exhibitions relative to other related content, feel free to add them using the field above. If you'd like to ensure that certain exhibitions never show up on this artist's detail page, use the following field:</p>

        @formField('browser', [
            'name' => 'hidden_related_items',
            'endpoints' => [
                [
                    'label' => 'Exhibition',
                    'value' => '/exhibitions_events/exhibitions/browser'
                ],
                [
                    'label' => 'Videos',
                    'value' => '/collection/articles_publications/videos/browser'
                ],
            ],
            'max' => 1000,
            'label' => 'Suppressed related items',
        ])

    </a17-fieldset>

    @include('admin.partials.meta')

@endsection
