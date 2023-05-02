@extends('twill::layouts.form')

@section('contentFields')
    @formField('select', [
        'name' => 'type',
        'label' => 'Page type',
        'default' => \App\Models\LandingPage::PAGE_TYPE_HOME,
        'inline' => true,
        'options' => [
            [
                'value' => \App\Models\LandingPage::PAGE_TYPE_HOME,
                'label' => 'Home'
            ],
            [
                'value' => \App\Models\LandingPage::PAGE_TYPE_EXHIBITIONS_AND_EVENTS,
                'label' => 'Exhibitions and Events'
            ],
            [
                'value' => \App\Models\LandingPage::PAGE_TYPE_THE_COLLECTION,
                'label' => 'The Collection'
            ],
            [
                'value' => \App\Models\LandingPage::PAGE_TYPE_VISIT,
                'label' => 'Visit'
            ],
            [
                'value' => \App\Models\LandingPage::PAGE_TYPE_ARTICLES,
                'label' => 'Articles landing'
            ],
            [
                'value' => \App\Models\LandingPage::PAGE_TYPE_EXHIBITION_HISTORY,
                'label' => 'Exhibition History'
            ],
            [
                'value' => \App\Models\LandingPage::PAGE_TYPE_COLLECTION,
                'label' => 'Collection landing'
            ],
            [
                'value' => \App\Models\LandingPage::PAGE_TYPE_RESEARCH_LANDING,
                'label' => 'Research landing'
            ],
            [
                'value' => \App\Models\LandingPage::PAGE_TYPE_WRITINGS_LANDING,
                'label' => 'Writings landing'
            ],
        ]
    ])

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'type',
        'fieldValues' => \App\Models\LandingPage::PAGE_TYPE_HOME,
        'renderForBlocks' => false
    ])
        @formField('input', [
            'name' => 'home_intro',
            'label' => 'Intro text',
            'type' => 'textarea'
        ])

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
    @endcomponent

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'type',
        'fieldValues' => \App\Models\LandingPage::PAGE_TYPE_VISIT,
        'renderForBlocks' => false
    ])
        @formField('medias', [
            'name' => 'visit_hero',
            'label' => 'Hero image',
            'note' => 'Minimum image width 3000px'
        ])

        @formField('files', [
            'name' => 'video',
            'label' => 'Hero video',
            'note' => 'Add an MP4 file'
        ])

        @formField('medias', [
            'name' => 'visit_mobile',
            'label' => 'Hero image, mobile',
            'note' => 'Minimum image width 2000px'
        ])

        @formField('checkbox', [
            'name' => 'visit_hide_hours',
            'label' => 'Hide hours table and image',
        ])

        @formField('input', [
            'name' => 'visit_hour_intro',
            'label' => 'Intro text',
            'type' => 'textarea'
        ])

        @formField('medias', [
            'name' => 'visit_featured_hour',
            'label' => 'Image',
            'max' => '1',
            'note' => 'Minimum image width 2000px'
        ])
        @formField('wysiwyg', [
            'name' => 'visit_hour_image_caption',
            'field_name' => 'visit_hour_image_caption',
            'label' => 'Image caption',
            'toolbarOptions' => [
                'italic', 'link'
            ],
        ])
        @formField('input', [
            'name' => 'visit_hour_header',
            'field_name' => 'visit_hour_header',
            'label' => 'Header',
            'required' => true
        ])
        @formField('wysiwyg', [
            'name' => 'visit_hour_subheader',
            'field_name' => 'visit_hour_subheader',
            'label' => 'Description',
            'required' => true
        ])
        @formField('repeater', ['type' => 'featured_hours'])
    @endcomponent

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'type',
        'fieldValues' => \App\Models\LandingPage::PAGE_TYPE_RESEARCH_LANDING,
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

    @formField('block_editor', [
        'blocks' => BlockHelpers::getBlocksForEditor([
            'paragraph', 'image', 'video', 'media_embed', 'quote',
            'list', 'artwork', 'hr', 'citation', 'split_block', 'grid',
            'membership_banner', 'digital_label', 'audio_player', 'tour_stop', 'button', 'mobile_app',
            '3d_model', '3d_tour', '3d_embed', '360_embed', '360_modal',
            'gallery_new',
            'image_slider', 'mirador_embed', 'mirador_modal', 'vtour_embed',
            'feature_2x', 'feature_4x'
        ])
    ])
@stop