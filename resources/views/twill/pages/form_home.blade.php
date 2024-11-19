@section('contentFields')
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
@stop

@section('fieldsets')
    <a17-fieldset title="Plan your visit" id="plan-your-visit">
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

    <a17-fieldset title="Video carousel" id="video-carousel">

        @formField('input', [
            'name' => 'home_video_title',
            'label' => 'Title',
        ])

        @formField('wysiwyg', [
            'name' => 'home_video_description',
            'label' => 'Description',
            'toolbarOptions' => [
                'italic'
            ],
        ])

        @formField('browser', [
            'routePrefix' => 'collection.articles_publications',
            'max' => 10,
            'moduleName' => 'videos',
            'name' => 'homeVideos',
            'label' => 'Video carousel'
        ])
    </a17-fieldset>

    <a17-fieldset title="Call to Action Module" id="call-to-action">

        @formField('medias', [
            'label' => 'Image',
            'name' => 'home_cta_module_image'
        ])

        @formField('input', [
            'name' => 'home_cta_module_header',
            'label' => 'Header',
        ])

        @formField('wysiwyg', [
            'name' => 'home_cta_module_body',
            'label' => 'Body',
            'toolbarOptions' => [
                'italic'
            ],
        ])

        @formField('input', [
            'name' => 'home_cta_module_button_text',
            'label' => 'Button text',
        ])

        @formField('radios', [
            'name' => 'variation',
            'label' => 'Variation',
            'default' => \App\Models\Lightbox::VARIATION_DEFAULT,
            'inline' => false,
            'options' => array_merge([
                [
                    'value' => \App\Models\Lightbox::VARIATION_DEFAULT,
                    'label' => 'Default (button)'
                ],
                [
                    'value' => \App\Models\Lightbox::VARIATION_NEWSLETTER,
                    'label' => 'Newsletter (button + email input)'
                ],
                [
                    'value' => \App\Models\Lightbox::VARIATION_EMAIL,
                    'label' => 'Email capture (button + email input)'
                ],
            ], !config('aic.show_button_and_date_select_lightbox_variation') ? [] : [
                [
                'value' => \App\Models\Lightbox::VARIATION_TICKETING,
                'label' => 'Ticketing (button + date select) (WIP)'
                ],
            ]),
        ])

        <p>If you choose any variation except "Newsletter", you must fill out the "Metadata" fields below. The "Newsletter" variation works like the newsletter signup in our footer.</p>

        <hr>

        @formField('input', [
            'name' => 'home_cta_module_action_url',
            'label' => 'Action URL',
            'note' => 'e.g. https://join.artic.edu/secure/holiday-annual-fund',
        ])

        @formField('input', [
            'name' => 'home_cta_module_form_tlc_source',
            'label' => 'Form TLC Source',
            'note' => 'e.g. AIC17137L01',
        ])

        @formField('input', [
            'name' => 'home_cta_module_form_token',
            'label' => 'Form Token',
            'note' => 'e.g. pa5U17siEjW4suerjWEB5LP7sFJYgAwLZYMS6kNTEag',
        ])

        @formField('input', [
            'name' => 'home_cta_module_form_id',
            'label' => 'Form ID',
            'note' => 'e.g. webform_client_form_5111',
        ])
    </a17-fieldset>

    <a17-fieldset title="Highlights" id="highlights">
        @formField('browser', [
            'routePrefix' => 'collection',
            'max' => 10,
            'moduleName' => 'highlights',
            'name' => 'homeHighlights',
            'label' => 'Highlights'
        ])
    </a17-fieldset>

    <a17-fieldset title="Artists" id="artists">
        @formField('repeater', [ 'type' => 'artists' ])
    </a17-fieldset>

    <a17-fieldset title="From the Collection" id="from-the-collection">
        @formField('browser', [
            'routePrefix' => 'collection',
            'max' => 20,
            'moduleName' => 'artworks',
            'name' => 'homeArtworks',
            'label' => 'Artworks'
        ])
    </a17-fieldset>

    <a17-fieldset title="From the Shop" id="from-the-shop">
        @formField('browser', [
            'routePrefix' => 'general',
            'max' => 5,
            'moduleName' => 'shopItems',
            'name' => 'homeShopItems',
            'label' => 'Featured shop items',
            'note' => 'Select up to 5 shop items you want to feature on the homepage'
        ])
    </a17-fieldset>

    <a17-fieldset title="Exhibitions and Event" id="exhibitions-and-events">
        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'max' => 2,
            'moduleName' => 'exhibitions',
            'name' => 'homeExhibitions',
            'label' => 'Featured exhibitions'
        ])

        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'max' => 10,
            'moduleName' => 'events',
            'name' => 'homeEvents',
            'label' => 'Featured events',
            'note' => 'Select up to 10 events you want to feature on the homepage'
        ])
    </a17-fieldset>
@stop
