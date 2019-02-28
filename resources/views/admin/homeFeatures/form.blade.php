@extends('twill::layouts.form')

@section('contentFields')
    @formField('medias', [
        'label' => 'Hero',
        'name' => 'hero',
        'note' => 'Minimum image width 3000px'
    ])

    @formField('files', [
        'name' => 'video',
        'label' => 'Video file',
        'note' => 'Add an MP4 file'
    ])

    @php
        $selectedFeature = 'articles';
        foreach (['articles', 'events', 'exhibitions', 'selections'] as $featureType) {
            if (isset($form_fields['browsers'][$featureType]) && !empty($form_fields['browsers'][$featureType])) {
                $selectedFeature = $featureType;
            }
        }
    @endphp

    @formField('radios', [
        'name' => '_featureType',
        'label' => 'Feature type',
        'default' => $selectedFeature,
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
            [
                'value' => 'selections',
                'label' => 'Collection Highlights'
            ],
        ]
    ])


    @component('twill::partials.form.utils._connected_fields', [
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

    @component('twill::partials.form.utils._connected_fields', [
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

    @component('twill::partials.form.utils._connected_fields', [
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

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => '_featureType',
        'renderForBlocks' => false,
        'fieldValues' => 'selections'
    ])
        @formField('browser', [
            'routePrefix' => 'collection',
            'moduleName' => 'selections',
            'name' => 'selections',
            'label' => 'Collection Highlights'
        ])
    @endcomponent
@stop
