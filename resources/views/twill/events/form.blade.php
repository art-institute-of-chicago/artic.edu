@extends('twill::layouts.form', [
    'disableContentFieldset' => true,
    'additionalFieldsets' => [
        ['fieldset' => 'title_and_image', 'label' => 'Title and Image'],
        ['fieldset' => 'dates', 'label' => 'Date Rules'],
        ['fieldset' => 'ticketing', 'label' => 'Ticketing Info'],
        ['fieldset' => 'sales_site', 'label' => 'Sales Site'],
        ['fieldset' => 'content', 'label' => 'Content'],
        ['fieldset' => 'sponsors', 'label' => 'Sponsors'],
        ['fieldset' => 'related_elements', 'label' => 'Related'],
        ['fieldset' => 'filters_and_types', 'label' => 'Filters and Types'],
        ['fieldset' => 'metadata', 'label' => 'Metadata'],
        ['fieldset' => 'event_series', 'label' => 'Email Series'],
    ]
])

@section('fieldsets')

    <x-twill::formFieldset id="title_and_image" title="Title and Image">
        <x-twill::input
            name='title_display'
            label='Title formatting (optional)'
            note='Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
        />

        <hr>

        <x-twill::select
            name='layout_type'
            label='Hero type'
            default='0'
            :options='$eventLayoutsList'
        />

        @include('twill.partials.hero')

        <p><strong>Note:</strong> Hero images are used by event listings, ticketing pages, and the mobile app.</p>
    </x-twill::formFieldset>

    <x-twill::formFieldset id="dates" title="Date rules">
        <x-twill::input
            name='all_dates_cms'
            label='All computed dates'
            note='Dates built using all rules below.'
            type='textarea'
            disabled='true'
            :rows='2'
        />

        <x-twill::formColumns>
            <x-slot:left>
                <x-twill::select
                    name='start_time'
                    label='Start Time'
                    :options='DateHelpers::hoursSelectOptions()'
                    :required='true'
                />

                <x-twill::select
                    name='door_time'
                    label='Door Time'
                    :options="DateHelpers::hoursSelectOptions()"
                />
            </x-slot:left>
            <x-slot:right>
                <x-twill::select
                    name='end_time'
                    label='End Time'
                    :options='DateHelpers::hoursSelectOptions()'
                    :required='true'
                />
            </x-slot:right>
        </x-twill::formColumns>

        <x-twill::input
            name='forced_date'
            label='Force the event to show this text as date'
            note='Optional, the event will show this instead of the automatic computed date'
        />

        <x-twill::repeater
            type='date_rule'
            title='Date rule'
        />
    </x-twill::formFieldset>

    <x-twill::formFieldset id="ticketing" title="Ticketing Information">
        <p>Select the "Ticketed Event" box when you want a "Buy Tickets" button to appear on the event page. If the event is associated with the ticketing system, the button will not appear until the ticketed event is on sale.</p>

        <x-twill::checkbox
            name='is_ticketed'
            label='Ticketed Event'
        />

        <x-twill::browser
            name='ticketedEvent'
            label='Event from ticketing system'
            route-prefix='exhibitionsEvents'
            module-name='ticketedEvents'
            :max='1'
        />

        <x-twill::input
            name='rsvp_link'
            label='Custom tickets link'
            note="Only use this field when using an alternate sales platform' e.g., Eventbrite."
        />

        <x-twill::input
            name='buy_tickets_link'
            label='Button link preview'
            readonly='true'
            note='Save and refresh the page to see the link preview'
        />

        <x-twill::radios
            name='buy_button_text'
            label='Sales button text'
            default='Buy Tickets'
            :inline='true'
            :options="[
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
                ]
            ]"
        />

        <hr/>

        <x-twill::wysiwyg
            name='buy_button_caption'
            label='Pricing or attendance information'
            note='e.g. add cost of event or other relevant information'
            :toolbar-options="[ 'bold' ]"
        />

        <p>If you attach an event from the ticketing system, we will automatically display the date and time of when its registration opens above this text in the sidebar.</p>

        <hr/>
        <p>Event Tags<br/>
        <span class="f--note f--small">Will display a tag above the event title</span></p>

        <x-twill::checkbox
            name='is_member_exclusive'
            label='Member Exclusive'
        />

        <hr/>
        <p>Event Labels<br/>
        <span class="f--note f--small">Will display a label beneath the event time</span></p>

        <x-twill::checkbox
            name='is_registration_required'
            label='Registration Required'
        />

        <x-twill::checkbox
            name='is_sold_out'
            label='Sold Out'
        />

        <x-twill::checkbox
            name='is_rsvp'
            label='RSVP'
        />

        <x-twill::checkbox
            name='is_free'
            label='Free'
        />

        <p>If you attach an event from the ticketing system, we will handle "Sold Out" for you automatically.</p>

        <hr/>
        <p>Private<br/>
        <span class="f--note f--small">Does not generate any labels or tags, only excludes the event from the listing</span></p>

        <x-twill::checkbox
            name='is_private'
            label='Is Private'
        />

        <x-twill::checkbox
            name='is_sales_button_hidden'
            label='Hide Sales Button'
        />
    </x-twill::formFieldset>

    <x-twill::formFieldset id="sales_site" title="Sales site fields">
        <x-twill::checkbox
            name='is_admission_required'
            label='Is Admission Required'
        />

        <x-twill::checkbox
            name='is_after_hours'
            label='Is After Hours'
        />

        @php
            $eventEntrancesList->put(strval(\App\Models\Event::NULL_OPTION), '[None]');
        @endphp

        <x-twill::select
            name='entrance'
            label='Entrance'
            default='{{ \App\Models\Event::NULL_OPTION }}' {{-- No effect? --}}
            :options="$eventEntrancesList"
        />

        <x-twill::checkbox
            name='is_virtual_event'
            label='Is Virtual Event'
        />

        <x-twill::input
            name='virtual_event_url'
            label='Virtual event URL'
        />

        <x-twill::input
            name='virtual_event_passcode'
            label='Virtual event passcode'
        />
    </x-twill::formFieldset>

    <x-twill::formFieldset title="Content" id="content" data-sticky-top="publisher">
        <p><strong>Note:</strong> For the following three fields, please keep character count below 255.</p>

        <x-twill::wysiwyg
            name='description'
            label='Header'
            note='Used by website, displayed above main content'
            :maxlength='255'
            :toolbar-options="[ 'italic' ]"
        />

        <x-twill::wysiwyg
            name='short_description'
            label='Short description (required)'
            note='Used by Sales Site and for event emails'
            :required='true'
            :toolbar-options="[ 'italic' ]"
        />

        <x-twill::wysiwyg
            name='list_description'
            label='Listing description'
            note='Used by website and Mobile App for listings'
            :maxlength="255"
            :required='true'
            :toolbar-options="[ 'italic' ]"
        />

        <hr>

        <x-twill::input
            name='location'
            label='Location'
            note='Displayed in left sidebar'
        />

        @php
            $blocks = BlockHelpers::getBlocksForEditor([
                'paragraph', 'image', 'hr', 'artwork', 'split_block', 'gallery_new', 'link', 'video', 'quote', 'tour_stop', 'media_embed', 'list', 'timeline', 'button', 'newsletter_signup_inline', 'audio_player', '3d_model', 'mobile_app'
            ]);
        @endphp

        <x-twill::block-editor
            :blocks='$blocks'
        />
    </x-twill::formFieldset>

    <x-twill::formFieldset id="sponsors" title="Sponsors">
        <x-twill::browser
            name='sponsors'
            label='Sponsors'
            route-prefix='exhibitionsEvents'
            module-name='sponsors'
            note='Display content blocks from this sponsor'
            :max='1'
        />
    </x-twill::formFieldset>

    <x-twill::formFieldset id="related_elements" title="Related Events">
        <x-twill::browser
            name='events'
            label='Related events'
            route-prefix='exhibitionsEvents'
            module-name='events'
            note='Show up to 4 events at bottom of page'
            :max='4'
        />
    </x-twill::formFieldset>

    <x-twill::formFieldset id="filters_and_types" title="Filters and types">
        @php
            $eventTypesList->put(strval(\App\Models\Event::NULL_OPTION), '[None]');
            $eventAudiencesList->put(strval(\App\Models\Event::NULL_OPTION), '[None]')
        @endphp

        <x-twill::select
            name='event_type'
            label='Event type (preferred)'
            :options="$eventTypesList"
            default='\App\Models\Event::NULL_OPTION' {{-- No effect? --}}
        />

        <x-twill::multi-select
            name='alt_types'
            label='Event type (alternative)'
            note='Used to enhance filtering'
            unpack='true'
            :options="$eventTypesList"
        />

        <x-twill::select
            name='audience'
            label='Event audience (preferred)'
            :options="$eventAudiencesList"
            default='{{ \App\Models\Event::NULL_OPTION }}' {{-- No effect? --}}
        />

        <x-twill::multi-select
            name='alt_audiences'
            label='Event audience (alternative)'
            note='Used to enhance filtering'
            unpack='true'
            :options="$eventAudiencesList"
        />

        <x-twill::multi-select
            name='programs'
            label='Programs'
            note='To view program URLS, select programs below, update event, and refresh the page'
            unpack='true'
            :options="$eventProgramsList"
        />

        <x-twill::input
            name='program_urls'
            label='Program URLs'
            type='textarea'
            :rows='{{ $item->programs->count() }}'
            readonly='true'
        />
    </x-twill::formFieldset>

    {{--  WEB-2236: Use 'twill.partials.meta' as a component --}}
    <x-twill::formFieldset id="metadata" title="Overwrite default metadata (optional)">
        <x-twill::input
            name='meta_title'
            label='Metadata Title'
        />

        <x-twill::input
            name='meta_description'
            label='Metadata Description'
            type='textarea'
        />


        <x-twill::input
            name='search_tags'
            label='Internal Search Tags'
            type='textarea'
        />

        <p>Comma-separatated list of words or phrases. Don't worry about grammar or similar word variations. This field is intended to assist our internal search engine in finding your content. These tags will not be shown to website users and will have no effect on external search engines, e.g. Google.</p>
    </x-twill::formFieldset>

    @if (config('aic.show_event_series_emails'))

    <x-twill::formFieldset id="event_series" title="Event series emails">
        <p>Please review the <a href="https://docs.google.com/document/d/19SN1uMkJy2ldk83uBnEL0GHSZFDOB5j2exz-X1oSb4Y/edit">documentation for email series</a> before proceeding.</p>

        <x-twill::checkbox
            name='add_to_event_email_series'
            label='Add to event email series'
        />

        <x-twill::formConnectedFields
            field-name='add_to_event_email_series'
            field-values='true'
            :render-for-blocks='false'
        >
            <hr style="height: 5px; margin: 50px -20px 20px; padding: 0; background: #f2f2f2; border: 0 none;"/>

            @php
                // TODO: Use new null option!
                $options = $eventHostsList->put(strval(\App\Models\Event::NULL_OPTION_EVENT_HOST), '[None]');
            @endphp

            <x-twill::select
                name='event_host_id'
                label='Event Host'
                default='{{ \App\Models\Event::NULL_OPTION_EVENT_HOST }}' // No effect?
                note='This field is mandatory and will be used to determine audience list for email send'
                :required='true'
                :options="$options"
            />

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

                <x-twill::checkbox
                    name='$currentSeriesName'
                    label='$currentSeriesTitle'
                />

                <x-twill::formConnectedFields
                    field-name='{{ $currentSeriesName }}'
                    field-values='true'
                    :render-for-blocks='false'
                >

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

                        @php
                            $name = $currentSeriesName . '_' . $subFieldName . '_override';
                            $label = $useShortLabel ? 'Override default copy' : 'Include ' . $subFieldLabel . '-specific copy (overrides default copy)';
                        @endphp

                        <x-twill::checkbox
                            name="$name"
                            label="$label"
                        />

                        <x-twill::formConnectedFields
                            field-name="$name"
                            field-values='true'
                            :render-for-blocks='false'
                        >

                            <div style="padding-left: 35px">

                            @php
                                $name = $currentSeriesName . '_' . $subFieldName . '_copy';
                            @endphp

                            <x-twill::wysiwyg
                                name="$name"
                                label='Copy'
                                :toolbar-options="[ 'bold', 'italic', 'link' ]"
                            />

                            </div>

                        </x-twill::formConnectedFields>

                    @endforeach

                    </div>

                </x-twill::formConnectedFields>

            @endforeach

            <hr style="height: 5px; margin: 50px -20px 20px; padding: 0; background: #f2f2f2; border: 0 none;"/>

            <x-twill::input
                name='join_url'
                label='Join URL'
            />

            <x-twill::input
                name='survey_url'
                label='Questionnaire Survey URL'
                note='Sent 1 day after user registers if URL is populated'
            />

            <br>

            <p><b>Note:</b> This is the questionnaire for event options or guest names, not the Event Response Survey.</p>

            <hr style="height: 5px; margin: 50px -20px 20px; padding: 0; background: #f2f2f2; border: 0 none;"/>

            <x-twill::checkbox
                name='send_test_emails'
                label='Send test emails after save'
            />

            <x-twill::formConnectedFields
                field-name='send_test_emails'
                field-values='true'
                :render-for-blocks='false'
            >

                <hr style="height: 5px; margin: 30px -20px 20px; padding: 0; background: #f2f2f2; border: 0 none;"/>

                <p>By default, test emails will be sent to the Email Marketing Manager and to any addresses specified in the list that is associated with this event's host in Salesforce. Use this field to add your email to the list of recipients.</p>

                <x-twill::input
                    name='test_emails'
                    label='Extra Email Addresses'
                    note='One or more comma-separated email addresses'
                />

                <hr style="height: 5px; margin: 50px -20px 20px; padding: 0; background: #f2f2f2; border: 0 none;"/>

                <p>Please select which test emails you'd like to send:</p>

                @foreach ( \App\Models\EmailSeries::ordered()->get() as $series)

                    @php
                        $currentSeriesName = 'email_series_' . $series->id;
                        $currentSeriesTitle = $series->title;

                        if (isset($series->timing_message)) {
                            $currentSeriesTitle .= ' (' . $series->timing_message . ')';
                        }
                    @endphp

                    <x-twill::formConnectedFields
                        field-name='{{ $currentSeriesName }}'
                        field-values='true'
                        :render-for-blocks='false'
                    >

                        @php
                            $name = $currentSeriesName . '_test';
                        @endphp

                        <x-twill::checkbox
                            name="$name"
                            label='$currentSeriesTitle'
                        />

                        @php
                            $subFields = \App\Models\EmailSeries::$memberTypes;

                            $enabledSubFields = array_filter($subFields, function ($subFieldName) use ($series) {
                                return $series->{'show_' . $subFieldName . '_test'};
                            }, ARRAY_FILTER_USE_KEY);
                        @endphp

                        @if (count($enabledSubFields) < 1)

                            <div style="padding-left: 25px; padding-top: 20px; font-style: italic">
                                <b>Warning:</b> No "Send [Audience] Test" options enabled for the above email series! No tests will be sent for it.
                            </div>

                        @elseif(count($enabledSubFields) > 1)

                            @php
                                $name = $currentSeriesName . '_test';
                            @endphp

                            <x-twill::formConnectedFields
                                field-name="$name"
                                field-values='true'
                                :render-for-blocks='false'
                            >

                                <div style="padding-left: 35px">

                                    @foreach ($enabledSubFields as $subFieldName => $subFieldLabel)

                                        @php
                                            $name = $currentSeriesName . '_test_' . $subFieldName;
                                            $label = 'Send ' . $subFieldLabel . ' test';
                                        @endphp
                                        <x-twill::checkbox
                                            name="$name"
                                            label="$label"
                                        />

                                    @endforeach

                                </div>

                            </x-twill::formConnectedFields>

                        @endif

                    </x-twill::formConnectedFields>

                @endforeach

            </x-twill::formConnectedFields>

        </x-twill::formConnectedFields>

    </x-twill::formFieldset>

    @endif

@endsection
