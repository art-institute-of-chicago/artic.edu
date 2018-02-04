@extends('cms-toolkit::layouts.form')

@section('contentFields')
    {{-- @formField('input', [
        'name' => 'title',
        'label' => 'Title',
    ]) --}}

    @formField('select', [
        'name' => 'type',
        'label' => 'Event type',
        'options' => $eventTypesList,
        'default' => '0'
    ])

    @formField('checkbox', [
        'name' => 'hidden',
        'label' => 'Hidden from listings?',
    ])

    @formField('checkbox', [
        'name' => 'is_ongoing',
        'label' => 'Ongoing Event?'
    ])

    @formField('date_picker', [
        'name' => 'start_date',
        'label' => 'Start date',
    ])

    @formField('date_picker', [
        'name' => 'end_date',
        'label' => 'End date'
    ])

    @formField('select', [
        'name' => 'layout_type',
        'label' => 'Event layout',
        'options' => $eventLayoutsList,
        'default' => '0'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Hero Image',
        'name' => 'hero'
    ])

    @formField('input', [
        'name' => 'hero_caption',
        'label' => 'Hero Image Caption'
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
            'disabled' => true
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
            'name' => 'is_ticketed',
            'label' => 'Ticketed Event?'
        ])

        @formField('checkbox', [
            'name' => 'is_sold_out',
            'label' => 'Sold Out?',
        ])

        @formField('checkbox', [
            'name' => 'is_free',
            'label' => 'Free Event?'
        ])

        @formField('input', [
            'name' => 'buy_button_text',
            'label' => 'Buy Tickets button text',
            'note' => 'E.G. Buy Tickets'
        ])

        @formField('input', [
            'name' => 'buy_button_caption',
            'label' => 'Copy below Buy Button text',
            'type' => 'textarea'
        ])

        @formField('checkbox', [
            'name' => 'is_boosted',
            'label' => 'Boost this Article on search results'
        ])
    </a17-fieldset>
@endsection
