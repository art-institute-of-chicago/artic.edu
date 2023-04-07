@extends('twill::layouts.form')

@section('contentFields')
    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Hero image',
        'name' => 'hero',
        'note' => 'Minimum image width 3000px'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Mobile Hero Image',
        'name' => 'mobile_hero',
        'note' => 'Minimum image width 3000px'
    ])

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
                'value' => 'highlights',
                'label' => 'Collection Highlights'
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
        @formField('input', [
            'name' => 'tag',
            'label' => 'Tag',
            'note' => 'Small text, eg "Exhibition"'
        ])

        @formField('input', [
            'name' => 'call_to_action',
            'label' => 'Call to action',
            'note' => 'Displays where dates do for Exhibitions'
        ])

        @formField('input', [
            'name' => 'url',
            'label' => 'URL for link'
        ])
    @endcomponent
@stop
