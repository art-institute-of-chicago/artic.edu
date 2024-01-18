@extends('twill::layouts.form')
@section('contentFields')
    @formField('input', [
        'name' => 'title',
        'label' => 'Title',
    ])
    @formField('input', [
        'name' => 'intro',
        'label' => 'Intro',
    ])
    @formField('select', [
        'name' => 'header_variation',
        'label' => 'Header Style',
        'placeholder' => 'Select style of page header',
        'default' => 'default',
        'options' => [
            [
                'value' => 'default',
                'label' => 'Default',
            ],
            [
                'value' => 'small',
                'label' => 'Small Image',
            ],
            [
                'value' => 'cta',
                'label' => 'Call to action',
            ],
            [
                'value' => 'feature',
                'label' => 'Featured Content',
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
            'note' => 'Minimum image width 3000px',
        ])
        @formField('files', [
            'name' => 'video',
            'label' => 'Hero video',
            'note' => 'Add an MP4 file',
        ])
        @formField('medias', [
            'name' => 'mobile_hero',
            'label' => 'Hero image, mobile',
            'note' => 'Minimum image width 2000px',
        ])
    @endcomponent
    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'header_variation',
        'fieldValues' => 'cta',
        'renderForBlocks' => false,
    ])
        @formField('input', [
            'name' => 'header_cta_title',
            'label' => 'CTA Title',
        ])
        @formField('input', [
            'name' => 'header_cta_button_label',
            'label' => 'Button Label',
        ])
        @formField('input', [
            'name' => 'header_cta_button_link',
            'label' => 'Button Link',
        ])
    @endcomponent
    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'header_variation',
        'fieldValues' => 'feature',
        'renderForBlocks' => false,
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
    <a17-fieldset title="Navigation Menu" id="nav-menu">
        @formField('repeater', ['type' => 'menu_items'])
    </a17-fieldset>
    <a17-fieldset title="Hours" id="hours">
        @formField('input', [
            'name' => 'hour_header',
            'label' => 'Hour Header',
        ])
        @formField('wysiwyg', [
            'name' => 'hour_intro',
            'label' => 'Hour Intro',
            'toolbarOptions' => [
                'bold', 'italic', 'link',
            ],
        ])
        @formField('checkbox', [
            'name' => 'is_custom_hours',
            'label' => 'Override default hours',
        ])
        @component('twill::partials.form.utils._connected_fields', [
            'fieldName' => 'is_custom_hours',
            'fieldValues' => true
        ])
            @formField('repeater', ['type' => 'featured_hours'])
        @endcomponent
    </a17-fieldset>
    <a17-fieldset title="Location" id="location">
        @formField('input', [
            'name' => 'labels.location_header',
            'label' => 'Location Header',
        ])
        @formField('medias', [
            'name' => 'rlc_location',
            'label' => 'Location Image',
        ])
        @formField('wysiwyg', [
            'name' => 'labels.location_intro',
            'label' => 'Location Intro',
            'toolbarOptions' => [
                'bold', 'italic', 'link',
            ],
        ])
        @formField('input', [
            'name' => 'labels.directions_label',
            'label' => 'Directions Label',
        ])
        @formField('input', [
            'name' => 'labels.directions_link',
            'label' => 'Directions Link',
        ])
        @formField('input', [
            'name' => 'labels.visit_museum_button_label',
            'label' => 'Visit Museum Button Label',
        ])
        @formField('input', [
            'name' => 'labels.visit_museum_button_link',
            'label' => 'Visit Museum Button Link',
        ])
    </a17-fieldset>
    <a17-fieldset title="Custom Content" id="custom_content">
        @formField('block_editor', [
            'blocks' => [
                'showcase',
                'showcase_multiple',
            ],
        ])
    </a17-fieldset>
@stop
