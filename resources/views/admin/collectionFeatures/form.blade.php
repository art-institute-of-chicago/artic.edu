@extends('twill::layouts.form')

@section('contentFields')
    @php
        $selectedFeature = 'articles';
        foreach (['articles', 'artworks', 'selections', 'digitalLabel'] as $featureType) {
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
                'value' => 'artworks',
                'label' => 'Artwork'
            ],
            [
                'value' => 'selections',
                'label' => 'Highlight'
            ],
            [
                'value' => 'digitalLabels',
                'label' => 'Digital Label'
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
        'fieldValues' => 'artworks'
    ])
        @formField('browser', [
            'routePrefix' => 'collection',
            'moduleName' => 'artworks',
            'name' => 'artworks',
            'label' => 'Artworks'
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
            'label' => 'Highlight'
        ])
    @endcomponent

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => '_featureType',
        'renderForBlocks' => false,
        'fieldValues' => 'digitalLabels'
    ])
        @formField('browser', [
            'routePrefix' => 'collection',
            'moduleName' => 'digitalLabels',
            'name' => 'digitalLabels',
            'label' => 'Digital Label'
        ])
    @endcomponent
@stop
