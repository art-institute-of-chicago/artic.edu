@extends('twill::layouts.form')

@section('contentFields')
    <x-twill::medias
        name='hero'
        label='Hero image'
        note='Minimum image width 3000px'
    />

    <x-twill::medias
        name='mobile_hero'
        label='Mobile Hero Image'
        note='Minimum image width 3000px'
    />

    <x-twill::files
        name='video'
        label='Video file'
        note='Add an MP4 file'
    />

    @php
        $selectedFeature = 'articles';
        if ($item->item()) {
            $selectedFeature = $item->item->type;
            if ($item->item->url) {
                $selectedFeature = 'custom';
            }
        }
    @endphp

    <x-twill::radios
        name='_featureType'
        label='Feature type'
        default="$selectedFeature"
        :inline='true'
        :options="[
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
                'value' => 'highlights',
                'label' => 'Collection Highlights'
            ],
            [
                'value' => 'custom',
                'label' => 'Custom'
            ]
        ]"
    />


    <x-twill::formConnectedFields
        field-name="_featureType"
        field-values="articles"
        :render-for-blocks="false"
    >
        <x-twill::browser
            name='articles'
            label='Article'
            route-prefix='collection.articlesPublications'
            module-name='articles'
        />
    </x-twill::formConnectedFields>

    <x-twill::formConnectedFields
        field-name="_featureType"
        field-values="events"
        :render-for-blocks="false"
    >
        <x-twill::browser
            name='events'
            label='Event'
            route-prefix='exhibitionsEvents'
            module-name='events'
        />
    </x-twill::formConnectedFields>

    <x-twill::formConnectedFields
        field-name="_featureType"
        field-values="exhibitions"
        :render-for-blocks="false"
    >
        <x-twill::browser
            name='exhibitions'
            label='Exhibition'
            route-prefix='exhibitionsEvents'
            module-name='exhibitions'
        />
    </x-twill::formConnectedFields>

    <x-twill::formConnectedFields
        field-name="_featureType"
        field-values="highlights"
        :render-for-blocks="false"
    >
        <x-twill::browser
            name='highlights'
            label='Collection Highlights'
            route-prefix='collection'
            module-name='highlights'
        />
    </x-twill::formConnectedFields>

    <x-twill::formConnectedFields
        field-name="_featureType"
        field-values="custom"
        :render-for-blocks="false"
    >
        <x-twill::input
            name='tag'
            label='Tag'
            note='Small text, eg "Exhibition"'
        />

        <x-twill::input
            name='call_to_action'
            label='Call to action'
            note='Displays where dates do for Exhibitions'
        />

        <x-twill::input
            name='url'
            label='URL for link'
        />
    </x-twill::formConnectedFields>
@stop
