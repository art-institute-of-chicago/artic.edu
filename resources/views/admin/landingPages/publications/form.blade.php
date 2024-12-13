@extends('twill::layouts.form')

@section('contentFields')

@formField('select', [
    'name' => 'header_variation',
    'label' => 'Header Style',
    'placeholder' => 'Select style of page header',
    'default' => 'default',
    'options' => [
        [
            'value' => 'default',
            'label' => 'Default'
        ],
        [
            'value' => 'small',
            'label' => 'Small Image'
        ],
        [
            'value' => 'cta',
            'label' => 'Call to action'
        ],
        [
            'value' => 'feature',
            'label' => 'Featured Content'
        ],
    ]
])

<hr/>

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'header_variation',
    'fieldValues' => ['default', 'small', 'cta'],
    'renderForBlocks' => false
])

    @formField('medias', [
        'name' => 'hero',
        'label' => 'Hero image',
        'note' => 'Minimum image width 3000px'
    ])

    @formField('files', [
        'name' => 'video',
        'label' => 'Hero video',
        'note' => 'Add an MP4 file'
    ])

    @formField('medias', [
        'name' => 'mobile_hero',
        'label' => 'Hero image, mobile',
        'note' => 'Minimum image width 2000px'
    ])

@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'header_variation',
    'fieldValues' => 'cta',
    'renderForBlocks' => false
])

    @formField('input', [
        'name' => 'header_cta_title',
        'label' => 'CTA Title'
    ])

    @formField('input', [
        'name' => 'header_cta_button_label',
        'label' => 'Button Label'
    ])

    @formField('input', [
        'name' => 'header_cta_button_link',
        'label' => 'Button Link'
    ])

@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'header_variation',
    'fieldValues' => 'feature',
    'renderForBlocks' => false
])

    @formField('browser', [
        'routePrefix' => 'generic',
        'max' => 3,
        'moduleName' => 'pageFeatures',
        'name' => 'primaryFeatures',
        'label' => 'Main feature',
        'note' => 'Queue up to 3 home features for the large hero area',
    ])

@endcomponent

@stop

@section('fieldsets')

@stop
