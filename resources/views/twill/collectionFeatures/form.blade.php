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

    <x-twill::radios
        name='_featureType'
        label='Feature type'
        default='$selectedFeature'
        :inline='true'
        :options="[
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
            ]
        ]"
    />

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => '_featureType',
        'renderForBlocks' => false,
        'fieldValues' => 'articles'
    ])
        <x-twill::browser
            name='articles'
            label='Article'
            route-prefix='collection.articlesPublications'
            module-name='articles'
        />
    @endcomponent

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => '_featureType',
        'renderForBlocks' => false,
        'fieldValues' => 'artworks'
    ])
        <x-twill::browser
            name='artworks'
            label='Artworks'
            route-prefix='collection'
            module-name='artworks'
        />
    @endcomponent

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => '_featureType',
        'renderForBlocks' => false,
        'fieldValues' => 'highlights'
    ])
        <x-twill::browser
            name='highlights'
            label='Highlight'
            route-prefix='collection'
            module-name='highlights'
        />
    @endcomponent

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => '_featureType',
        'renderForBlocks' => false,
        'fieldValues' => 'experiences'
    ])
        <x-twill::browser
            name='experiences'
            label='Interactive Feature'
            route-prefix='collection.interactiveFeatures'
            module-name='experiences'
        />
    @endcomponent
@stop
