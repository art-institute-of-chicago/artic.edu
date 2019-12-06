@extends('twill::layouts.form', [
    'additionalFieldsets' => [
        ['fieldset' => 'sponsors', 'label' => 'Sponsors'],
        ['fieldset' => 'attributes', 'label' => 'Attributes'],
        ['fieldset' => 'related', 'label' => 'Related'],
        ['fieldset' => 'side_related', 'label' => 'Sidebar Related'],
        ['fieldset' => 'offers', 'label' => 'Offers and Products'],
        ['fieldset' => 'api', 'label' => 'Datahub fields'],
    ]
])

@section('contentFields')
    @formField('input', [
        'name' => 'title_display',
        'label' => 'Title formatting (optional)',
        'note' => 'Use <i> tag to add italics, e.g. <i>Nighthawks</i>'
    ])

    @formField('select', [
        'name' => 'cms_exhibition_type',
        'label' => 'Exhibition layout',
        'options' => $exhibitionTypesList,
        'default' => '0',
        'note' => '"Special" crop is used for "Special exhibition" layout',
    ])

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Hero image',
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

    @component('twill::partials.form.utils._columns')
        @slot('left')
            @formField('date_picker', [
                'name' => 'public_start_date',
                'label' => 'Public Start Date',
                'withTime' => false,
                'placeholder' => isset($item) && $item->aic_start_at ? (new \Carbon\Carbon($item->aic_start_at))->toFormattedDateString() : null,
            ])
        @endslot
        @slot('right')
            @formField('date_picker', [
                'name' => 'public_end_date',
                'label' => 'Public End Date',
                'withTime' => false,
                'placeholder' => isset($item) && $item->aic_end_at ? (new \Carbon\Carbon($item->aic_end_at))->toFormattedDateString() : null,
            ])
        @endslot
    @endcomponent

    @component('twill::partials.form.utils._columns')
        @slot('left')
            @formField('date_picker', [
                'name' => 'member_preview_start_date',
                'label' => 'Member Preview Start Date',
                'withTime' => false,
                'placeholder' => '',
            ])
        @endslot
        @slot('right')
            @formField('date_picker', [
                'name' => 'member_preview_end_date',
                'label' => 'Member Preview End Date',
                'withTime' => false,
                'placeholder' => '',
            ])
        @endslot
    @endcomponent

    @formField('wysiwyg', [
        'name' => 'header_copy',
        'label' => 'Header',
        'maxlength' => 255,
        'note' => 'Max 255 characters',
        'toolbarOptions' => [
            'italic'
        ],
    ])

    @formField('wysiwyg', [
        'name' => 'list_description',
        'label' => 'Listing description',
        'maxlength'  => 255,
        'note' => 'Max 255 characters',
        'toolbarOptions' => [
            'italic'
        ],
    ])

    @formField('wysiwyg', [
        'name' => 'exhibition_message',
        'label' => 'Pricing or attendance information',
        'toolbarOptions' => ['bold']
    ])

    @formField('input', [
        'name' => 'exhibition_location',
        'label' => 'Exhibition location',
        'note' => 'Override CITI gallery location'
    ])

     @formField('select', [
        'name' => 'status_override',
        'label' => 'Exhibition status',
        'note' => 'Override exhibition status flag',
        'options' => $exhibitionStatusesList,
    ])

    @formField('block_editor', [
        'blocks' => getBlocksForEditor([
            'event', 'paragraph', 'image', 'video', 'gallery',
            'media_embed', 'quote', 'list', 'accordion', 'newsletter_signup_inline',
            'timeline', 'link', 'artwork', 'artworks',
            'hr', 'split_block', 'tour_stop', 'button', 'mobile_app'
        ])
    ])
@stop

@section('fieldsets')
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

    <a17-fieldset id="attributes" title="Attributes">
        @formField('input', [
            'name' => 'datahub_id',
            'label' => 'Datahub ID',
            'disabled' => true
        ])

        @formField('multi_select', [
            'name' => 'siteTags',
            'label' => 'Tags',
            'options' => $siteTagsList,
            'placeholder' => 'Select some tags',
        ])
    </a17-fieldset>
    <a17-fieldset id="related" title="Related">
        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'max' => 4,
            'name' => 'exhibitions',
            'label' => 'Related exhibitions'
        ])

        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'moduleName' => 'events',
            'name' => 'events',
            'label' => 'Related events',
            'note' => 'Select related events',
            'max' => 20
        ])
    </a17-fieldset>

    <a17-fieldset id="offers" title="Offers and Products">
        @formField('repeater', ['type' => 'offers'])

        <hr />

        @formField('input', [
            'name' => 'product_section_title',
            'label' => 'Shop section title',
            'note' => 'Defaults to "Related Products" if blank'
        ])

        @formField('input', [
            'name' => 'product_section_title_link_label',
            'label' => 'Shop link label',
            'note' => 'Defaults to "Explore the shop" if blank'
        ])

        @formField('input', [
            'name' => 'product_section_title_link_href',
            'label' => 'Shop link URL',
            'note' => 'Defaults to "https://shop.artic.edu" if blank'
        ])

        @formField('browser', [
            'routePrefix' => 'general',
            'name' => 'shopItems',
            'moduleName' => 'shopItems',
            'label' => 'Shop items',
            'max' => 5,
        ])
    </a17-fieldset>

    @component('admin.partials.featured-related', ['form_fields' => $form_fields])
        @slot('routePrefix', 'exhibitions_events')
        @slot('moduleName', 'exhibitions')
        @slot('articles', 'articles')
        @slot('events', 'sidebarEvent')
        @slot('exhibitions', 'sidebarExhibitions')
        @slot('experiences', null)
        @slot('videos', 'videos')
    @endcomponent

    @include('admin.partials.related')

    @include('admin.partials.meta')

    <a17-fieldset id="api" title="Datahub fields">
        @formField('input', [
            'name' => 'title',
            'label' => 'Title',
            'disabled' => true
        ])
        @formField('input', [
            'name' => 'description',
            'label' => 'Description',
            'type' => 'textarea',
            'disabled' => true
        ])
        @formField('input', [
            'name' => 'short_description',
            'label' => 'Short description',
            'type' => 'textarea',
            'disabled' => true
        ])
        @formField('input', [
            'name' => 'start_at',
            'label' => 'Start at',
            'disabled' => true
        ])
        @formField('input', [
            'name' => 'end_at',
            'label' => 'End at',
            'disabled' => true
        ])
        @formField('input', [
            'name' => 'status',
            'label' => 'Status',
            'disabled' => true
        ])
        @formField('input', [
            'name' => 'lake_guid',
            'label' => 'Lake GUID',
            'disabled' => true
        ])
        @formField('input', [
            'name' => 'department_title',
            'label' => 'Department',
            'disabled' => true
        ])
        @formField('input', [
            'name' => 'department_id',
            'label' => 'Department ID',
            'disabled' => true
        ])
        @formField('input', [
            'name' => 'gallery_title',
            'label' => 'Gallery',
            'disabled' => true
        ])
        @formField('input', [
            'name' => 'gallery_id',
            'label' => 'Gallery ID',
            'disabled' => true
        ])
        @formField('input', [
            'name' => 'type',
            'label' => 'Type',
            'disabled' => true
        ])
        @formField('input', [
            'name' => 'last_updated',
            'label' => 'Last updated',
            'disabled' => true
        ])
        @formField('input', [
            'name' => 'artwork_ids',
            'label' => 'Artwork IDs',
            'disabled' => true
        ])
        @formField('input', [
            'name' => 'venue_ids',
            'label' => 'Venue IDs',
            'disabled' => true
        ])
        @formField('input', [
            'name' => 'site_ids',
            'label' => 'Site IDs',
            'disabled' => true
        ])
        @formField('input', [
            'name' => 'event_ids',
            'label' => 'Event IDs',
            'disabled' => true
        ])
    </a17-fieldset>
@stop
