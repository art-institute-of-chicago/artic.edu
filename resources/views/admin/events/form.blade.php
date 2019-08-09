@extends('twill::layouts.form', [
    'additionalFieldsets' => [
        ['fieldset' => 'filters_and_types', 'label' => 'Filters and Types'],
        ['fieldset' => 'ticketing', 'label' => 'Ticketing Information'],
        ['fieldset' => 'dates', 'label' => 'Date Rules'],
        ['fieldset' => 'sponsors', 'label' => 'Sponsors'],
        ['fieldset' => 'related_elements', 'label' => 'Related'],
        ['fieldset' => 'metadata', 'label' => 'Metadata'],
        ['fieldset' => 'sales_site', 'label' => 'Sales Site'],
        ['fieldset' => 'event_series', 'label' => 'Email Series'],
    ]
])

@section('contentFields')
    @formField('input', [
        'name' => 'title_display',
        'label' => 'Title formatting (optional)',
        'note' => 'Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
    ])

    <hr>

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
        'maxlength' => 255,
        'toolbarOptions' => [
            'italic', 'link',
        ],
    ])

    <p><strong>Note:</strong> Hero images are used by event listings, ticketing pages, and the mobile app.</p>

    <hr>

    <p><strong>Note:</strong> For the following three fields, please keep character count below 255.</p>

    @formField('wysiwyg', [
        'name' => 'description',
        'label' => 'Header',
        'maxlength' => 255,
        'note' => 'Used by website, displayed above main content',
        'toolbarOptions' => [
            'italic'
        ],
    ])

    @formField('wysiwyg', [
        'name' => 'short_description',
        'label' => 'Short description (required)',
        'note' => 'Used by Sales Site and for event emails',
        'required' => true,
        'toolbarOptions' => [
            'italic'
        ],
    ])

    @formField('wysiwyg', [
        'name' => 'list_description',
        'label' => 'Listing description',
        'maxlength'  => 255,
        'note' => 'Used by website and Mobile App for listings',
        'toolbarOptions' => [
            'italic'
        ],
    ])

    <hr>

    @formField('input', [
        'name' => 'location',
        'label' => 'Location',
        'note' => 'Displayed in left sidebar',
    ])

    @formField('block_editor', [
        'blocks' => getBlocksForEditor([
            'paragraph', 'image', 'video', 'gallery', 'media_embed', 'quote',
            'list', 'newsletter_signup_inline', 'timeline', 'link',
            'artworks', 'artwork', 'hr', 'split_block', 'tour_stop', 'button',
            'mobile_app'
        ])
    ])
@stop

@section('fieldsets')

    <a17-fieldset id="filters_and_types" title="Filters and types">
        @formField('select', [
            'name' => 'event_type',
            'label' => 'Event type (preferred)',
            'options' => $eventTypesList->put(strval(\App\Models\Event::NULL_OPTION), '[None]'),
            'default' => \App\Models\Event::NULL_OPTION, // no effect?
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
            'options' => $eventAudiencesList->put(strval(\App\Models\Event::NULL_OPTION), '[None]'),
            'default' => \App\Models\Event::NULL_OPTION, // no effect?
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
        <p>Select the "Ticketed Event" box when you want a "Buy Tickets" button to appear on the event page. If the event is associated with the ticketing system, the button will not appear until the ticketed event is on sale.</p>

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
            'name' => 'rsvp_link',
            'label' => 'Custom tickets link',
            'note' => 'Only use this field when using an alternate sales platform, e.g., Eventbrite.'
        ])

        @formField('input', [
            'name' => 'buy_tickets_link',
            'label' => 'Button link preview',
            'disabled' => 'true',
            'note' => 'Save and refresh the page to see the link preview',
        ])

        @formField('radios', [
            'name' => 'buy_button_text',
            'label' => 'Sales button text',
            'default' => 'Buy Tickets',
            'inline' => true,
            'options' => [
                [
                    'value' => 'Buy Tickets',
                    'label' => 'Buy Tickets'
                ],
                [
                    'value' => 'Register',
                    'label' => 'Register'
                ],
                [
                    'value' => 'RSVP',
                    'label' => 'RSVP'
                ],
            ]
        ])

        <hr/>

        @formField('wysiwyg', [
            'name' => 'buy_button_caption',
            'label' => 'Pricing or attendance information',
            'note' => 'e.g. add cost of event or other relevant information',
            'toolbarOptions' => ['bold']
        ])

        <p>If you attach an event from the ticketing system, we will automatically display the date and time of when its registration opens above this text in the sidebar.</p>

        <hr/>
        <p>Event Tags<br/>
        <span class="f--note f--small">Will display a tag above the event title</span></p>

        @formField('checkbox', [
            'name' => 'is_member_exclusive',
            'label' => 'Member Exclusive',
        ])

        <hr/>
        <p>Event Labels<br/>
        <span class="f--note f--small">Will display a label beneath the event time</span></p>

        @formField('checkbox', [
            'name' => 'is_registration_required',
            'label' => 'Registration Required',
        ])

        @formField('checkbox', [
            'name' => 'is_sold_out',
            'label' => 'Sold Out',
        ])

        @formField('checkbox', [
            'name' => 'is_rsvp',
            'label' => 'RSVP',
        ])

        @formField('checkbox', [
            'name' => 'is_free',
            'label' => 'Free',
        ])

        <p>If you attach an event from the ticketing system, we will handle "Sold Out" for you automatically.</p>

        <hr/>
        <p>Private<br/>
        <span class="f--note f--small">Does not generate any labels or tags, only excludes the event from the listing</span></p>

        @formField('checkbox', [
            'name' => 'is_private',
            'label' => 'Is Private',
        ])

        @formField('checkbox', [
            'name' => 'is_sales_button_hidden',
            'label' => 'Hide Sales Button',
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

    {{-- TODO: Use 'admin.partials.meta' as a component --}}
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

    <a17-fieldset id="sales_site" title="Sales site fields">
        @formField('checkbox', [
            'name' => 'is_admission_required',
            'label' => 'Is Admission Required',
        ])

        @formField('checkbox', [
            'name' => 'is_after_hours',
            'label' => 'Is After Hours',
        ])

        @formField('select', [
            'name' => 'entrance',
            'label' => 'Entrance',
            'options' => $eventEntrancesList->put(strval(\App\Models\Event::NULL_OPTION), '[None]'),
            'default' => \App\Models\Event::NULL_OPTION, // no effect?
        ])
    </a17-fieldset>

    <a17-fieldset id="event_series" title="Event series emails">
        <p>Please review the <a href="https://docs.google.com/document/d/19SN1uMkJy2ldk83uBnEL0GHSZFDOB5j2exz-X1oSb4Y/edit">documentation for email series</a> before proceeding.</p>

        @formField('checkbox', [
            'name' => 'add_to_event_email_series',
            'label' => 'Add to event email series',
        ])

        @component('twill::partials.form.utils._connected_fields', [
            'fieldName' => 'add_to_event_email_series',
            'renderForBlocks' => false,
            'fieldValues' => true
        ])
            <hr style="height: 5px; margin: 50px -20px 20px; padding: 0; background: #f2f2f2; border: 0 none;"/>

            @formField('select', [
                'name' => 'event_host_id',
                'label' => 'Event Host',
                'options' => $eventHostsList->put(
                    // TODO: Use new null option!
                    strval(\App\Models\Event::NULL_OPTION_EVENT_HOST), '[None]'
                ),
                'default' => \App\Models\Event::NULL_OPTION_EVENT_HOST, // no effect?
                'note' => 'This field is mandatory and will be used to determine audience list for email send',
                'required' => true,
            ])

            @formField('checkbox', [
                'name' => 'show_presented_by',
                'label' => 'Include "This event is presented by the %%EventHost%%." in all pre-registration event emails',
            ])

            <hr style="height: 5px; margin: 50px -20px 20px; padding: 0; background: #f2f2f2; border: 0 none;"/>

            <p>Please select the emails you wish to opt-in to:</p>

            @foreach ( \App\Models\EmailSeries::ordered()->get() as $series)

                @php
                    $currentSeriesName = 'email_series_' . $series->id;
                    $currentSeriesTitle = $series->title;

                    if (isset($series->timing_message)) {
                        $currentSeriesTitle .= ' (' . $series->timing_message . ')';
                    }
                @endphp

                @formField('checkbox', [
                    'name' => $currentSeriesName,
                    'label' => $currentSeriesTitle,
                ])

                @component('twill::partials.form.utils._connected_fields', [
                    'fieldName' => $currentSeriesName,
                    'renderForBlocks' => false,
                    'fieldValues' => true
                ])

                    <div style="padding-left: 35px">

                    @if ($series->alert_message)
                        <div style="padding-top: 35px">
                            {!! $series->alert_message !!}
                        </div>
                    @endif

                    @php
                        $subFields = \App\Models\EmailSeries::$memberTypes;

                        $enabledSubFields = array_filter($subFields, function ($subFieldName) use ($series) {
                            return $series->{'show_' . $subFieldName};
                        }, ARRAY_FILTER_USE_KEY);

                        $useShortLabel = count($enabledSubFields) < 2;
                    @endphp

                    @foreach ($enabledSubFields as $subFieldName => $subFieldLabel)

                        @formField('checkbox', [
                            'name' => $currentSeriesName . '_' . $subFieldName . '_override',
                            'label' => ($useShortLabel ?
                                'Override default copy' :
                                'Include ' . $subFieldLabel . '-specific copy (overrides default copy)'
                            ),
                        ])

                        @component('twill::partials.form.utils._connected_fields', [
                            'fieldName' => $currentSeriesName . '_' . $subFieldName . '_override',
                            'renderForBlocks' => false,
                            'fieldValues' => true
                        ])

                            <div style="padding-left: 35px">

                            @formField('wysiwyg', [
                                'name' => $currentSeriesName . '_' . $subFieldName . '_copy',
                                'label' => '',
                                'toolbarOptions' => [
                                    'bold', 'italic', 'link'
                                ],
                            ])

                            </div>

                        @endcomponent

                    @endforeach

                    </div>

                @endcomponent

            @endforeach

            <hr style="height: 5px; margin: 50px -20px 20px; padding: 0; background: #f2f2f2; border: 0 none;"/>

            @formField('input', [
                'name' => 'join_url',
                'label' => 'Join URL'
            ])

            @formField('input', [
                'name' => 'survey_url',
                'label' => 'Questionnaire Survey URL',
                'note' => 'Sent 1 day after user registers if URL is populated',
            ])

            <br>

            <p><b>Note:</b> This is the questionnaire for event options or guest names, not the Event Response Survey.</p>
        @endcomponent

    </a17-fieldset>

@endsection
