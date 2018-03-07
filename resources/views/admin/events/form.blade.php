@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('select', [
        'name' => 'layout_type',
        'label' => 'Event layout',
        'options' => $eventLayoutsList,
        'default' => '0'
    ])

    @formField('select', [
        'name' => 'type',
        'label' => 'Event type',
        'options' => $eventTypesList,
        'default' => '1'
    ])

    @formField('select', [
        'name' => 'type',
        'label' => 'Event audience',
        'options' => $eventAudiencesList,
        'default' => '1'
    ])

    @formField('checkbox', [
        'name' => 'hidden',
        'label' => 'Hidden from listings?',
    ])

    @formField('checkbox', [
        'name' => 'is_ongoing',
        'label' => 'Ongoing Event?'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Hero Image',
        'name' => 'hero'
    ])

    @formField('input', [
        'name' => 'hero_caption',
        'label' => 'Hero Image Caption',
        'note' => 'Usually used for copyright'
    ])

    @formField('input', [
        'name' => 'short_description',
        'label' => 'Short description',
        'note' => 'Used at the landing page and SEO'
    ])

    @formField('input', [
        'name' => 'description',
        'label' => 'Description',
        'type' => 'textarea'
    ])

    @formField('input', [
        'name' => 'list_description',
        'label' => 'List Description',
        'type' => 'textarea'
    ])

    @formField('multi_select', [
        'name' => 'siteTags',
        'label' => 'Tags',
        'options' => $siteTagsList,
        'placeholder' => 'Select some tags',
    ])

    @formField('checkbox', [
        'name' => 'is_private',
        'label' => 'Is Private?',
    ])

    @formField('input', [
        'name' => 'rsvp_link',
        'label' => 'External RSVP Link'
    ])

    @formField('input', [
        'name' => 'sponsors_description',
        'label' => 'Sponsors section description',
        'type' => 'textarea'
    ])

    @formField('input', [
        'name' => 'sponsors_sub_copy',
        'label' => 'Sponsors sub copy',
        'note' => 'E.G. further support provided by'
    ])

    @formField('block_editor', [
        'blocks' => [
            'paragraph', 'image_with_caption', 'video_with_caption', 'gallery',
            'media_embed', 'quote', 'list', 'related_offers', 'newsletter_signup_inline',
            'sponsor', 'timeline', 'link'
        ]
    ])
@stop

@section('fieldsets')

    <a17-fieldset id="dates" title="Date Rules">
        @formField('input', [
            'name' => 'all_dates',
            'label' => 'All computed dates',
            'note' => 'Dates built using all rules below.',
            'type' => 'textarea',
            'disabled' => true,
            'rows' => 2
        ])

        @component('cms-toolkit::partials.form.utils._columns')
            @slot('left')
                @formField('select', [
                    'name' => 'start_time',
                    'label' => 'Start Time',
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
            'title' => 'Date Rule',
        ])
    </a17-fieldset>

    <a17-fieldset id="related_elements" title="Related elements">
        @formField('browser', [
            'routePrefix' => 'general',
            'moduleName' => 'sponsors',
            'name' => 'sponsors',
            'label' => 'Sponsors',
            'note' => 'Select Sponsors',
            'max' => 20
        ])

        @formField('browser', [
            'routePrefix' => 'whatson',
            'moduleName' => 'events',
            'name' => 'events',
            'label' => 'Related Events',
            'note' => 'Select events',
            'max' => 4
        ])
    </a17-fieldset>

    <a17-fieldset id="attributes" title="Attributes">
        @formField('input', [
            'name' => 'location',
            'label' => 'Location'
        ])

        @formField('checkbox', [
            'name' => 'is_member_exclusive',
            'label' => 'Members exclusive event?'
        ])

        @formField('checkbox', [
            'name' => 'is_after_hours',
            'label' => 'After Hours?'
        ])

        @formField('checkbox', [
            'name' => 'is_sold_out',
            'label' => 'Sold Out?',
        ])

        @formField('checkbox', [
            'name' => 'is_free',
            'label' => 'Free Event?'
        ])

        @formField('checkbox', [
            'name' => 'is_ticketed',
            'label' => 'Ticketed Event?'
        ])

        @formField('input', [
            'name' => 'buy_tickets_link',
            'label' => 'External Link to buy tickets'
        ])

        @formField('input', [
            'name' => 'buy_button_text',
            'label' => 'Buy Tickets button text',
            'note' => 'E.G. Buy Tickets'
        ])

        @formField('wysiwyg', [
            'name' => 'buy_button_caption',
            'label' => 'Copy below Buy Button text',
            'toolbarOptions' => ['bold']
        ])

        @formField('checkbox', [
            'name' => 'is_boosted',
            'label' => 'Boost this Article on search results'
        ])
    </a17-fieldset>
@endsection
