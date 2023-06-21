@extends('twill::layouts.form')

@section('contentFields')

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

@stop

@section('fieldsets')

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'type',
    'fieldValues' => array_search('Home', $types),
    'renderForBlocks' => false
])

<a17-fieldset title="Header" id="home-header">

    @formField('input', [
        'name' => 'home_intro',
        'label' => 'Intro text',
        'type' => 'textarea'
    ])

</a17-fieldset>

<a17-fieldset title="Home Features" id="home-features">

    @formField('browser', [
        'routePrefix' => 'homepage',
        'max' => 3,
        'moduleName' => 'homeFeatures',
        'name' => 'mainHomeFeatures',
        'label' => 'Main feature',
        'note' => 'Queue up to 3 home features for the large hero area',
    ])

    @formField('browser', [
        'routePrefix' => 'homepage',
        'max' => 5,
        'moduleName' => 'homeFeatures',
        'name' => 'secondaryHomeFeatures',
        'label' => 'Secondary features',
        'note' => 'Queue up to 5 home features for the two smaller hero areas',
    ])

</a17-fieldset>

<a17-fieldset title="Home Visit" id="home-visit">

    @formField('input', [
        'name' => 'home_visit_button_text',
        'label' => 'Label for "Visit" button',
        'note' => 'Defaults to "Visit"',
    ])

    @formField('input', [
        'name' => 'home_visit_button_url',
        'label' => 'Link for "Visit" button',
        'note' => 'Defaults to "/visit"',
    ])

    <hr/>

    @formField('input', [
        'name' => 'home_plan_your_visit_link_1_text',
        'label' => 'First "Plan your visit" link text',
    ])

    @formField('input', [
        'name' => 'home_plan_your_visit_link_1_url',
        'label' => 'First "Plan your visit" link URL',
    ])

    @formField('input', [
        'name' => 'home_plan_your_visit_link_2_text',
        'label' => 'Second "Plan your visit" link text',
    ])

    @formField('input', [
        'name' => 'home_plan_your_visit_link_2_url',
        'label' => 'Second "Plan your visit" link URL',
    ])

    @formField('input', [
        'name' => 'home_plan_your_visit_link_3_text',
        'label' => 'Third "Plan your visit" link text',
    ])

    @formField('input', [
        'name' => 'home_plan_your_visit_link_3_url',
        'label' => 'Third "Plan your visit" link URL',
    ])

</a17-fieldset>
@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'type',
    'fieldValues' => array_search('Visit', $types),
    'renderForBlocks' => false
])

    <a17-fieldset title="Navigation Menu" id="visit_nav-menu">

        @formField('repeater', ['type' => 'menu_items'])

        @formField('input', [
            'name' => 'visit_nav_buy_tix_label',
            'label' => 'Tickets Label'
        ])

        @formField('input', [
            'name' => 'visit_nav_buy_tix_link',
            'label' => 'Tickets Link'
        ])

    </a17-fieldset>

    <a17-fieldset title="Hours" id="visit_hours">

        @formField('wysiwyg', [
            'name' => 'visit_members_intro',
            'label' => 'Member Intro',
            'toolbarOptions' => [
            'bold', 'italic', 'link'
            ],
        ])

        @formField('wysiwyg', [
            'name' => 'visit_hours_intro',
            'label' => 'Hours Intro',
            'toolbarOptions' => [
            'bold', 'italic', 'link'
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

    <a17-fieldset title="Admission" id="visit_admission">
        @formField('wysiwyg', [
            'name' => 'visit_admission_intro',
            'label' => 'Admission Intro'
        ])

        @formField('input', [
            'name' => 'visit_admission_tix_label',
            'label' => 'Tickets Label'
        ])

        @formField('input', [
            'name' => 'visit_admission_tix_link',
            'label' => 'Tickets Link'
        ])

        @formField('input', [
            'name' => 'visit_admission_members_label',
            'label' => 'Member Label'
        ])

        @formField('input', [
            'name' => 'visit_admission_members_link',
            'label' => 'Member Link'
        ])
    </a17-fieldset>

    <a17-fieldset title="Location" id="visit_hours">
        @formField('medias', [
            'name' => 'visit_map',
            'label' => 'Map Image',
            'note' => 'Minimum image width 3000px'
        ])

        @formField('repeater', ['type' => 'locations', 'max' => 2])

        @formField('input', [
            'name' => 'visit_parking_label',
            'label' => 'Parking Button Label'
        ])

        @formField('input', [
            'name' => 'visit_parking_link',
            'label' => 'Parking Button Link'
        ])
    </a17-fieldset>

@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'type',
    'fieldValues' => array_search('Research and Resources', $types),
    'renderForBlocks' => false
])
    @formField('input', [
        'name' => 'resources_landing_title',
        'label' => 'Title',
    ])

    @formField('input', [
        'name' => 'resources_landing_intro',
        'label' => 'Intro text',
        'type' => 'textarea'
    ])

    @formField('medias', [
        'label' => 'Hero image',
        'name' => 'research_landing_image'
    ])

    @formField('browser', [
    'routePrefix' => 'generic',
        'max' => 9,
        'moduleName' => 'genericPages',
        'name' => 'researchResourcesFeaturePages',
        'label' => 'Featured pages'
    ])

    @formField('browser', [
    'routePrefix' => 'generic',
        'max' => 3,
        'moduleName' => 'genericPages',
        'name' => 'researchResourcesStudyRooms',
        'label' => 'Study room pages'
    ])

    @formField('browser', [
    'routePrefix' => 'generic',
        'max' => 1,
        'moduleName' => 'genericPages',
        'name' => 'researchResourcesStudyRoomMore',
        'label' => 'Study room more link'
    ])
@endcomponent

<a17-fieldset title="Custom Content" id="custom_content">

    @formField('block_editor', [
        'blocks' => BlockHelpers::getBlocksForEditor([
            'paragraph', 'image', 'video', 'media_embed', 'quote',
            'list', 'artwork', 'hr', 'citation', 'split_block', 'grid',
            'membership_banner', 'digital_label', 'audio_player', 'tour_stop', 'button', 'mobile_app',
            '3d_model', '3d_tour', '3d_embed', '360_embed', '360_modal',
            'gallery_new',
            'image_slider', 'mirador_embed', 'mirador_modal', 'vtour_embed',
            'feature_2x', 'feature_4x', 'showcase', 'custom_banner', 'featured_pages_grid'
        ])
    ])

</a17-fieldset>

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'type',
    'fieldValues' => array_search('Visit', $types), // Visit
    'renderForBlocks' => false
])

    <a17-fieldset title="FAQs" id="faq">
        @formField('input', [
            'name' => 'visit_faqs_label',
            'label' => 'More FAQs Label'
        ])

        @formField('input', [
            'name' => 'visit_faqs_link',
            'label' => 'More FAQs Link'
        ])

        @formField('input', [
            'name' => 'visit_faq_more_link',
            'label' => "More FAQs and guidelines link"
        ])

        @formField('repeater', ['type' => 'faqs'])
    </a17-fieldset>

@endcomponent


@stop
