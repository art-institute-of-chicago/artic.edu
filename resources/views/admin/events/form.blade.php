@extends('twill::layouts.form', [
    'additionalFieldsets' => [
        ['fieldset' => 'attributes', 'label' => 'Attributes'],
        ['fieldset' => 'dates', 'label' => 'Date Rules'],
        ['fieldset' => 'sponsors', 'label' => 'Sponsors'],
        ['fieldset' => 'related_elements', 'label' => 'Right rail related slot'],
    ]
])

@section('contentFields')
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

    @formField('input', [
        'name' => 'hero_caption',
        'label' => 'Hero image Caption',
        'note' => 'Usually used for copyright',
        'maxlength' => 150
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

    <a17-fieldset id="attributes" title="Filters and types">
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
    </a17-fieldset>

    <a17-fieldset id="attributes" title="Event entrance attributes">
        @formField('checkbox', [
            'name' => 'is_registration_required',
            'label' => 'Requires registration'
        ])

        @formField('checkbox', [
            'name' => 'is_member_exclusive',
            'label' => 'Members exclusive event'
        ])

        @formField('checkbox', [
            'name' => 'is_after_hours',
            'label' => 'After Hours'
        ])

        @formField('checkbox', [
            'name' => 'is_sold_out',
            'label' => 'Sold Out',
        ])

        @formField('checkbox', [
            'name' => 'is_private',
            'label' => 'Is Private',
        ])

        @formField('input', [
            'name' => 'rsvp_link',
            'label' => 'External RSVP Link',
            'note' => 'RSVP link used when an event is private, or when is Free and Ticketed'
        ])

        @formField('checkbox', [
            'name' => 'is_free',
            'label' => 'Free Event'
        ])

        @formField('checkbox', [
            'name' => 'is_admission_required',
            'label' => 'Admission Required'
        ])

        @formField('input', [
            'name' => 'buy_tickets_link',
            'label' => 'Buy tickets link'
        ])

        @formField('input', [
            'name' => 'buy_button_text',
            'label' => 'Button text',
            'note' => 'E.G. Buy Tickets'
        ])

        @formField('wysiwyg', [
            'name' => 'buy_button_caption',
            'label' => 'Pricing or attendance information',
            'toolbarOptions' => ['bold']
        ])

        @formField('checkbox', [
            'name' => 'is_boosted',
            'label' => 'Boost this event on search results'
        ])
    </a17-fieldset>

    <a17-fieldset id="ticketing" title="Ticketing information">
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

        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'max' => 1,
            'moduleName' => 'ticketedEventTypes',
            'name' => 'ticketedEventType',
            'label' => 'Event type from ticketing system'
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
        @formField('wysiwyg', [
            'name' => 'sponsors_description',
            'label' => 'Sponsors section description',
            'toolbarOptions' => ['bold']
            'note' => 'DEPRECATED',
            'type' => 'textarea'
        ])

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
