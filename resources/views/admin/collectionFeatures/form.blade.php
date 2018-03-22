@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @php
        $selectedFeature = 'articles';
        foreach (['articles', 'artworks', 'selections'] as $featureType) {
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
                'label' => 'Selection'
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
        'fieldValues' => 'artworks'
    ])
        @formField('browser', [
            'routePrefix' => 'collection',
            'moduleName' => 'artworks',
            'name' => 'artworks',
            'label' => 'Artworks'
        ])
    @endcomponent

    @component('cms-toolkit::partials.form.utils._connected_fields', [
        'fieldName' => '_featureType',
        'renderForBlocks' => false,
        'fieldValues' => 'selections'
    ])
        @formField('browser', [
            'routePrefix' => 'collection',
            'moduleName' => 'selections',
            'name' => 'selections',
            'label' => 'Selection'
        ])
    @endcomponent
@stop
