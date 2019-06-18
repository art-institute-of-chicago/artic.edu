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

        @formField('browser', [
            'routePrefix' => 'collection.articles_publications',
            'name' => 'related_items',
            'moduleName' => 'articles',
            'endpoints' => [
                [
                    'label' => 'Article',
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
                    'label' => 'Exhibition',
                    'value' => '/exhibitions_events/exhibitions/browser'
                ],
            ],
            'max' => 1000,
            'label' => 'Related items',
        ])

    </a17-fieldset>

    @include('admin.partials.meta')

@endsection
