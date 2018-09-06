@extends('twill::layouts.form', [
    'additionalFieldsets' => [
        ['fieldset' => 'filters_and_types', 'label' => 'Filters and Types'],
        ['fieldset' => 'ticketing', 'label' => 'Ticketing Information'],
        ['fieldset' => 'dates', 'label' => 'Date Rules'],
        ['fieldset' => 'sponsors', 'label' => 'Sponsors'],
        ['fieldset' => 'related_elements', 'label' => 'Right rail related slot'],
    ]
])

@section('contentFields')
    @formField('input', [
        'name' => 'title_display',
        'label' => 'Title (HTML)',
        'note' => 'Use only for italics'
    ])

    @formField('checkbox', [
        'name' => 'hidden',
        'label' => 'Hidden from listings?',
    ])

    @formField('select', [
        'name' => 'layout_type',
        'label' => 'Hero type',
        'options' => $eventLayoutsList,
        'default' => '0'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Hero Image',
        'name' => 'hero',
        'note' => 'Minimum image width 3000px'
    ])

    @formField('wysiwyg', [
        'type' => 'textarea',
        'name' => 'hero_caption',
        'label' => 'Hero image Caption',
        'note' => 'Usually used for copyright',
        'maxlength' => 150,
        'toolbarOptions' => [
            'italic',
        ],
    ])

    @formField('input', [
        'name' => 'description',
        'label' => 'Header',
        'type' => 'textarea'
    ])

    @formField('input', [
        'name' => 'short_description',
        'label' => 'Short description',
        'note' => 'Used for SEO',
        'maxlength' => 255
    ])

    @formField('input', [
        'name' => 'list_description',
        'label' => 'List description',
        'type' => 'textarea',
        'maxlength' => 255
    ])

    @formField('input', [
        'name' => 'location',
        'label' => 'Location'
    ])

    @formField('block_editor', [
        'blocks' => [
            'paragraph', 'image', 'video', 'gallery', 'media_embed', 'quote',
            'list', 'newsletter_signup_inline', 'timeline', 'link', 'shop_items',
            'artworks', 'artwork'
        ]
    ])
@stop

@section('fieldsets')

    <a17-fieldset id="filters_and_types" title="Filters and types">
        @formField('select', [
            'name' => 'event_type',
            'label' => 'Event type (preferred)',
            'options' => $eventTypesList,
            'default' => '1'
        ])

        @formField('multi_select', [
            'name' => 'alt_types',
            'label' => 'Event type (alternative)',
            'note' => 'Used to enhance filtering',
            'options' => $eventTypesList,
        ])

        @formField('select', [
            'name' => 'audience',
            'label' => 'Event audience (preferred)',
            'options' => $eventAudiencesList,
            'default' => '1'
        ])

        @formField('multi_select', [
            'name' => 'alt_audiences',
            'label' => 'Event audience (alternative)',
            'note' => 'Used to enhance filtering',
            'options' => $eventAudiencesList,
        ])

        @formField('multi_select', [
            'name' => 'programs',
            'label' => 'Programs',
            'note' => 'To view program URLS, select programs below, update event, and refresh the page',
            'options' => $eventProgramsList,
        ])
        @formField('input', [
            'name' => 'program_urls',
            'label' => 'Program URLs',
            'type' => 'textarea',
            'rows' => $item->programs->count(),
            'disabled' => 'true',
        ])
    </a17-fieldset>

    <a17-fieldset id="ticketing" title="Ticketing Information">
        @formField('checkbox', [
            'name' => 'is_ticketed',
            'label' => 'Ticketed Event'
        ])

        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'max' => 1,
            'moduleName' => 'ticketedEvents',
            'name' => 'ticketedEvent',
            'label' => 'Event from ticketing system'
        ])

        @formField('input', [
            'name' => 'buy_tickets_link',
            'label' => 'Button link',
            'disabled' => 'true',
        ])

        @formField('input', [
            'name' => 'rsvp_link',
            'label' => 'Custom tickets link',
            'note' => 'Use this to set a custom ticket link and/or override the sales.artic.edu "Buy tickets link"'
        ])

        @formField('input', [
            'name' => 'buy_button_text',
            'label' => 'Button text',
            'note' => 'Optional, will override default button text, based on labels'
        ])

        @formField('wysiwyg', [
            'name' => 'buy_button_caption',
            'label' => 'Pricing or attendance information',
            'note' => 'e.g., add cost of event, or other relevant information',
            'toolbarOptions' => ['bold']
        ])

        <p>Event Labels</p>

        @formField('checkbox', [
            'name' => 'is_registration_required',
            'label' => 'Registration Required',
            'note' => 'Will display as default button text and event label in listings.',
        ])

        @formField('checkbox', [
            'name' => 'is_member_exclusive',
            'label' => 'Member Exclusive',
            'note' => 'Will display as default button text and event label in listings.',
        ])

        @formField('checkbox', [
            'name' => 'is_sold_out',
            'label' => 'Sold Out',
            'note' => 'Will display as default button text and event label in listings.',
        ])

        @formField('checkbox', [
            'name' => 'is_free',
            'label' => 'RSVP',
            'note' => 'Will display as default button text and event label in listings.'
        ])

        @formField('checkbox', [
            'name' => 'is_private',
            'label' => 'Is Private',
            'note' => 'Will remove event page from public calendar listing.',
        ])

        @formField('select', [
            'name' => 'email_series',
            'label' => 'Add to event email series?',
            'options' => [
                [
                    'value' => 'Yes',
                    'label' => 'Yes'
                ],
                [
                    'value' => 'No',
                    'label' => 'No'
                ],
            ],
            'default' => 'No',
        ])

        @formField('input', [
            'name' => 'survey_link',
            'label' => 'Survey URL',
        ])
    </a17-fieldset>

    <a17-fieldset id="dates" title="Date rules">
        @formField('input', [
            'name' => 'all_dates_cms',
            'label' => 'All computed dates',
            'note' => 'Dates built using all rules below.',
            'type' => 'textarea',
            'disabled' => true,
            'rows' => 2
        ])

        @component('twill::partials.form.utils._columns')
            @slot('left')
                @formField('select', [
                    'name' => 'start_time',
                    'label' => 'Start Time',
                    'options' => hoursSelectOptions()
                ])

                @formField('select', [
                    'name' => 'door_time',
                    'label' => 'Door Time',
                    'options' => hoursSelectOptions()
                ])
            @endslot
            @slot('right')
                @formField('select', [
                    'name' => 'end_time',
                    'label' => 'End Time',
                    'options' => hoursSelectOptions()
                ])
            @endslot
        @endcomponent

        @formField('input', [
            'name' => 'forced_date',
            'label' => 'Force the event to show this text as date',
            'note' => 'Optional, the event will show this instead of the automatic computed date',
            'type' => 'text'
        ])

        @formField('repeater', [
            'type' => 'dateRules',
            'title' => 'Date rule',
        ])
    </a17-fieldset>

    <a17-fieldset id="sponsors" title="Sponsors">
        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'moduleName' => 'sponsors',
            'name' => 'sponsors',
            'label' => 'Sponsors',
            'note' => 'Display content blocks from this sponsor',
            'max' => 1
        ])
    </a17-fieldset>

    <a17-fieldset id="related_elements" title="Right rail related slot">
        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'moduleName' => 'events',
            'name' => 'events',
            'label' => 'Related events',
            'note' => 'Select upto 4 events',
            'max' => 4
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
    </a17-fieldset>

@endsection
