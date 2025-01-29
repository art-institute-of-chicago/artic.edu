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

    <x-twill::formConnectedFields
        field-name='_featureType'
        field-values='articles'
        :render-for-blocks='false'
    >
        <x-twill::browser
            name='articles'
            label='Article'
            route-prefix='collection.articlesPublications'
            module-name='articles'
        />
    </x-twill::formConnectedFields>

    <x-twill::formConnectedFields
        field-name='_featureType'
        field-values='artworks'
        :render-for-blocks='false'
    >
        <x-twill::browser
            name='artworks'
            label='Artworks'
            route-prefix='collection'
            module-name='artworks'
        />
    </x-twill::formConnectedFields>

    <x-twill::formConnectedFields
        field-name='_featureType'
        field-values='highlights'
        :render-for-blocks='false'
    >
        <x-twill::browser
            name='highlights'
            label='Highlight'
            route-prefix='collection'
            module-name='highlights'
        />
    </x-twill::formConnectedFields>

    <x-twill::formConnectedFields
        field-name='_featureType'
        field-values='experiences'
        :render-for-blocks='false'
    >
        <x-twill::browser
            name='experiences'
            label='Interactive Feature'
            route-prefix='collection.interactiveFeatures'
            module-name='experiences'
        />
    </x-twill::formConnectedFields>
@stop
