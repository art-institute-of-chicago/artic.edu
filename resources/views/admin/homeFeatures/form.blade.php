@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('medias', [
        'label' => 'Hero',
        'name' => 'hero'
    ])

    @formField('radios', [
        'name' => '_featureType',
        'label' => 'Feature type',
        'default' => 'articles',
        'inline' => true,
        'options' => [
            [
                'value' => 'articles',
                'label' => 'Article'
            ],
            [
                'value' => 'events',
                'label' => 'Events'
            ],
            [
                'value' => 'exhibitions',
                'label' => 'Exhibitions'
            ],
        ]
    ])


    @component('cms-toolkit::partials.form.utils._connected_fields', [
        'fieldName' => '_featureType',
        'renderForBlocks' => false,
        'fieldValues' => 'articles'
    ])
        @formField('browser', [
            'routePrefix' => 'collection.articles_publications',
            'moduleName' => 'articles',
            'name' => 'articles',
            'label' => 'Article'
        ])
    @endcomponent

    @component('cms-toolkit::partials.form.utils._connected_fields', [
        'fieldName' => '_featureType',
        'renderForBlocks' => false,
        'fieldValues' => 'events'
    ])
        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'moduleName' => 'events',
            'name' => 'events',
            'label' => 'Event'
        ])
    @endcomponent

    @component('cms-toolkit::partials.form.utils._connected_fields', [
        'fieldName' => '_featureType',
        'renderForBlocks' => false,
        'fieldValues' => 'exhibitions'
    ])
        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'moduleName' => 'exhibitions',
            'name' => 'exhibitions',
            'label' => 'Exhibition'
        ])
    @endcomponent
{{--
    #2 Removed for now?
     @formField('browser', [
        'routePrefix' => 'collection',
        'moduleName' => 'artworks',
        'name' => 'artworks',
        'label' => 'Artworks'
    ])
 --}}
@stop
