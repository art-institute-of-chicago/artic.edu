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
            'label' => 'Featured Content',
        ],
        [
            'value' => 'my_museum_tour',
            'label' => 'My Museum Tour'
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

<a17-fieldset title="Home Features" id="home-features">

    @formField('browser', [
        'routePrefix' => 'homepage',
        'max' => 3,
        'moduleName' => 'homeFeatures',
        'name' => 'mainHomeFeatures',
        'label' => 'Main feature',
        'note' => 'Queue up to 3 home features for the large hero area',
    ])

@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'header_variation',
    'fieldValues' => 'my_museum_tour',
    'renderForBlocks' => false
])
    @formField('wysiwyg', [
        'name' => 'labels.header_my_museum_tour_text',
        'label' => 'Intro Text',
        'toolbarOptions' => [
            'italic'
        ],
    ])

    @component('twill::partials.form.utils._columns')
    @slot('left')
        @formField('input', [
            'name' => 'labels.header_my_museum_tour_primary_button_label',
            'label' => 'Primary Button Label'
        ])
    @endslot

    @slot('right')
        @formField('input', [
            'name' => 'labels.header_my_museum_tour_primary_button_link',
            'label' => 'Primary Button Link'
        ])
    @endslot
    @endcomponent

    @component('twill::partials.form.utils._columns')
    @slot('left')
        @formField('input', [
            'name' => 'labels.header_my_museum_tour_secondary_button_label',
            'label' => 'Secondary Button Label'
        ])
    @endslot

    @slot('right')
        @formField('input', [
            'name' => 'labels.header_my_museum_tour_secondary_button_link',
            'label' => 'Secondary Button Link'
        ])
    @endslot
    @endcomponent

    @formField('medias', [
        'label' => 'Hero Image',
        'name' => 'header_my_museum_tour_header_image'
    ])

    @formField('medias', [
        'label' => 'Mobile hero Image',
        'name' => 'header_my_museum_tour_header_image_mobile'
    ])

    @component('twill::partials.form.utils._columns')
    @slot('left')
        @formField('input', [
            'name' => 'labels.header_my_museum_tour_icon_choose_title',
            'label' => '`Choose` Title'
        ])
    @endslot

    @slot('right')
        @formField('input', [
            'name' => 'labels.header_my_museum_tour_icon_choose_desc',
            'label' => '`Choose` Description'
        ])
    @endslot
    @endcomponent

    @component('twill::partials.form.utils._columns')
    @slot('left')
        @formField('input', [
            'name' => 'labels.header_my_museum_tour_icon_personalize_title',
            'label' => '`Personalize` Title'
        ])
    @endslot

    @slot('right')
        @formField('input', [
            'name' => 'labels.header_my_museum_tour_icon_personalize_desc',
            'label' => '`Personalize` Description'
        ])
    @endslot
    @endcomponent

    @component('twill::partials.form.utils._columns')
    @slot('left')
        @formField('input', [
            'name' => 'labels.header_my_museum_tour_icon_finish_title',
            'label' => '`Finish` Title'
        ])
    @endslot

    @slot('right')
        @formField('input', [
            'name' => 'labels.header_my_museum_tour_icon_finish_desc',
            'label' => '`Finish` Description'
        ])
    @endslot
    @endcomponent

@endcomponent

@stop

@section('fieldsets')

    <a17-fieldset title="Custom Content" id="custom_content">

        @formField('block_editor', [
            'blocks' => BlockHelpers::getBlocksForEditor([
                'paragraph', 'image', 'video', 'media_embed', 'quote',
                'list', 'artwork', 'hr', 'citation', 'split_block', 'grid',
                'membership_banner', 'digital_label', 'audio_player', 'tour_stop', 'button', 'mobile_app',
                '3d_model', '3d_tour', '3d_embed', '360_embed', '360_modal',
                'gallery_new',
                'image_slider', 'mirador_embed', 'mirador_modal', 'vtour_embed',
                'feature_2x', 'feature_4x', 'showcase', 'custom_banner', 'featured_pages_grid', 'my_museum_tour_grid'
            ])
        ])

    </a17-fieldset>

    <a17-fieldset title="Call to Action (Create Tour)" id="create-call-to-action">

        @formField('medias', [
            'label' => 'Image',
            'name' => 'tours_create_cta_module_image'
        ])

        @formField('input', [
            'name' => 'labels.tours_create_cta_module_header',
            'label' => 'Header',
        ])

        @formField('wysiwyg', [
            'name' => 'labels.tours_create_cta_module_body',
            'label' => 'Body',
            'toolbarOptions' => [
                'italic'
            ],
        ])

        @formField('input', [
            'name' => 'labels.tours_create_cta_module_button_text',
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
            'name' => 'labels.tours_create_cta_module_action_url',
            'label' => 'Action URL',
            'note' => 'e.g. https://join.artic.edu/secure/holiday-annual-fund',
        ])

        @formField('input', [
            'name' => 'labels.tours_create_cta_module_form_tlc_source',
            'label' => 'Form TLC Source',
            'note' => 'e.g. AIC17137L01',
        ])

        @formField('input', [
            'name' => 'labels.tours_create_cta_module_form_token',
            'label' => 'Form Token',
            'note' => 'e.g. pa5U17siEjW4suerjWEB5LP7sFJYgAwLZYMS6kNTEag',
        ])

        @formField('input', [
            'name' => 'labels.tours_create_cta_module_form_id',
            'label' => 'Form ID',
            'note' => 'e.g. webform_client_form_5111',
        ])
    </a17-fieldset>
    <a17-fieldset title="Call to Action (Buy Tickets)" id="tickets-call-to-action">

        @formField('medias', [
            'label' => 'Image',
            'name' => 'tours_tickets_cta_module_image'
        ])

        @formField('input', [
            'name' => 'labels.tours_tickets_cta_module_header',
            'label' => 'Header',
        ])

        @formField('wysiwyg', [
            'name' => 'labels.tours_tickets_cta_module_body',
            'label' => 'Body',
            'toolbarOptions' => [
                'italic'
            ],
        ])

        @formField('input', [
            'name' => 'labels.tours_tickets_cta_module_button_text',
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
            'name' => 'labels.tours_tickets_cta_module_action_url',
            'label' => 'Action URL',
            'note' => 'e.g. https://join.artic.edu/secure/holiday-annual-fund',
        ])

        @formField('input', [
            'name' => 'labels.tours_tickets_cta_module_form_tlc_source',
            'label' => 'Form TLC Source',
            'note' => 'e.g. AIC17137L01',
        ])

        @formField('input', [
            'name' => 'labels.tours_tickets_cta_module_form_token',
            'label' => 'Form Token',
            'note' => 'e.g. pa5U17siEjW4suerjWEB5LP7sFJYgAwLZYMS6kNTEag',
        ])

        @formField('input', [
            'name' => 'labels.tours_tickets_cta_module_form_id',
            'label' => 'Form ID',
            'note' => 'e.g. webform_client_form_5111',
        ])
    </a17-fieldset>

    <a17-fieldset id="metadata" title="Overwrite default metadata (optional)">
        @formField('input', [
            'name' => 'meta_title',
            'label' => 'Metadata Title'
        ])

        @formField('input', [
            'name' => 'meta_description',
            'label' => 'Metadata Description',
            'type' => 'textarea'
        ])


        @formField('input', [
            'name' => 'search_tags',
            'label' => 'Internal Search Tags',
            'type' => 'textarea'
        ])

        <p>Comma-separatated list of words or phrases. Don't worry about grammar or similar word variations. This field is intended to assist our internal search engine in finding your content. These tags will not be shown to website users and will have no effect on external search engines, e.g. Google.</p>
    </a17-fieldset>

@stop
