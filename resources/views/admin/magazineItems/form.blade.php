@extends('twill::layouts.form')

@section('contentFields')
    @formField('wysiwyg', [
        'name' => 'list_description',
        'label' => 'List description',
        'maxlength' => 255,
        'note' => 'Max 255 characters',
        'toolbarOptions' => [
            'italic'
        ],
    ])

    @php
        $selectedFeature = 'articles';
        foreach (['articles', 'selections', 'experiences'] as $featureType) {
            if (isset($form_fields['browsers'][$featureType]) && !empty($form_fields['browsers'][$featureType])) {
                $selectedFeature = $featureType;
            }
        }
        if ($item->url) {
            $selectedFeature = 'custom';
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
                'value' => 'selections',
                'label' => 'Highlights'
            ],
            [
                'value' => 'experiences',
                'label' => 'Interactive Features'
            ],
            [
                'value' => 'custom',
                'label' => 'Custom'
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
        'fieldValues' => 'experiences'
    ])
        @formField('browser', [
            'routePrefix' => 'collection.interactive_features',
            'moduleName' => 'experiences',
            'name' => 'experiences',
            'label' => 'Interactive Feature'
        ])
    @endcomponent

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => '_featureType',
        'renderForBlocks' => false,
        'fieldValues' => 'custom'
    ])
        @formField('input', [
            'name' => 'tag',
            'label' => 'Tag',
            'note' => 'Small text, eg "Exhibition"'
        ])

        @formField('input', [
            'name' => 'description',
            'label' => 'Description',
        ])

        @formField('input', [
            'name' => 'call_to_action',
            'label' => 'Call to action',
        ])

        @formField('input', [
            'name' => 'url',
            'label' => 'URL for link'
        ])
    @endcomponent

@stop
