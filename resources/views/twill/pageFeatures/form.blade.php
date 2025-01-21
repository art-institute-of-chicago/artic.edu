@extends('twill::layouts.form')

@section('contentFields')
    <x-twill::medias
        label='Hero image'
        name='hero'
        note='Minimum image width 3000px'
    />

    <x-twill::medias
        label='Mobile Hero Image'
        name='mobile_hero'
        note='Minimum image width 3000px'
    />

    @formField('files', [
        'name' => 'video',
        'label' => 'Video file',
        'note' => 'Add an MP4 file'
    ])

    @php
        $selectedFeature = 'articles';
        foreach (['articles', 'events', 'exhibitions', 'highlights'] as $featureType) {
            if (isset($form_fields['browsers'][$featureType]) && !empty($form_fields['browsers'][$featureType])) {
                $selectedFeature = $featureType;
            }
        }
        if ($item->url) {
            $selectedFeature = 'custom';
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


    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => '_featureType',
        'renderForBlocks' => false,
        'fieldValues' => 'articles'
    ])
        @formField('browser', [
            'routePrefix' => 'collection.articlesPublications',
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
            'routePrefix' => 'exhibitionsEvents',
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
            'routePrefix' => 'exhibitionsEvents',
            'moduleName' => 'exhibitions',
            'name' => 'exhibitions',
            'label' => 'Exhibition'
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
            'label' => 'Collection Highlights'
        ])
    @endcomponent

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => '_featureType',
        'renderForBlocks' => false,
        'fieldValues' => 'custom'
    ])
        <x-twill::input
            name='tag'
            label='Tag'
            note='Small text eg "Exhibition"'
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
    @endcomponent
@stop
