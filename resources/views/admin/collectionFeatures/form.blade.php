@extends('twill::layouts.form')

@section('contentFields')
    @php
        $selectedFeature = 'articles';
        foreach (['articles', 'artworks', 'highlights', 'experiences'] as $featureType) {
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
                'value' => 'highlights',
                'label' => 'Highlight'
            ],
            [
                'value' => 'experiences',
                'label' => 'Interactive Feature'
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
        'fieldValues' => 'highlights'
    ])
        @formField('browser', [
            'routePrefix' => 'collection',
            'moduleName' => 'highlights',
            'name' => 'highlights',
            'label' => 'Highlight'
        ])
    @endcomponent

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => '_featureType',
        'renderForBlocks' => false,
        'fieldValues' => 'experiences'
    ])
        @formField('browser', [
            'routePrefix' => 'collection.interactive_features',
            'moduleName' => 'experiences',
            'name' => 'experiences',
            'label' => 'Interactive Feature'
        ])
    @endcomponent
@stop
