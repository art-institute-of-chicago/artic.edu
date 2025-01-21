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
    <x-twill::input
        name='title_display'
        label='Title formatting (optional)'
        note='Use <i> tag to add italics, e.g. <i>Nighthawks</i>'
    />

    <x-twill::select
        name='cms_exhibition_type'
        label='Exhibition layout'
        default='0'
        note='"Special" crop is used for "Special exhibition" layout'
        :options="$exhibitionTypesList"
    />

    @include('twill.partials.hero')

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

    <x-twill::input
        name='date_display_override'
        label='Date display override'
        note='Override exhibition start and end dates with custom text'
        :maxlength='255'
    />

    <x-twill::wysiwyg
        name='header_copy'
        label='Header'
        note='Max 255 characters'
        :maxlength='255'
        :toolbar-options="[ 'italic' ]"
    />

    <x-twill::wysiwyg
        name='list_description'
        label='Listing description'
        note='Max 255 characters'
        :maxlength="255"
        :required='true'
        :toolbar-options="[ 'italic' ]"
    />

    <x-twill::wysiwyg
        name='exhibition_message'
        label='Pricing or attendance information'
        :toolbar-options="[ 'bold' ]"
    />

    <x-twill::input
        name='exhibition_location'
        label='Exhibition location'
        note='Override CITI gallery location'
    />

    <x-twill::select
        name='status_override'
        label='Exhibition status'
        note='Override exhibition status flag'
        :options="$exhibitionStatusesList"
    />

    <x-twill::input
        name='type_override'
        label='Exhibition eyebrow'
        note='Override exhibition eyebrow'
    />

    @formField('block_editor', [
        'blocks' => BlockHelpers::getBlocksForEditor([
            'paragraph', 'image', 'hr', 'artwork', 'split_block', 'gallery_new', 'link', 'video', 'quote', 'tour_stop', 'accordion', 'media_embed', 'list', 'timeline', 'button', 'newsletter_signup_inline', 'audio_player', '360_embed', 'vtour_embed', 'mirador_embed', 'event', 'feature_2x', 'layered_image_viewer', '3d_model', 'feature_4x', 'mobile_app', 'mirador_modal', '360_modal'
        ])
    ])
@stop

@section('fieldsets')
    <a17-fieldset id="sponsors" title="Sponsors">
        @formField('browser', [
            'routePrefix' => 'exhibitionsEvents',
            'moduleName' => 'sponsors',
            'name' => 'sponsors',
            'label' => 'Sponsors',
            'note' => 'Display content blocks from this sponsor',
            'max' => 1
        ])
    </a17-fieldset>

    <a17-fieldset id="waitTime" title="Wait time">
        @formField('browser', [
            'routePrefix' => 'exhibitionsEvents',
            'moduleName' => 'waitTimes',
            'name' => 'waitTimes',
            'label' => 'Wait Time',
            'note' => 'Select a queue to display the wait time for',
            'max' => 1
        ])

        <x-twill::wysiwyg
            name='wait_time_override'
            label='Wait time copy'
            note='Content will display below wait time data'
            :maxlength='255'
            :toolbar-options="[ 'italic' ]"
        />
    </a17-fieldset>

    <a17-fieldset id="attributes" title="Attributes">
        <x-twill::input
            name='datahub_id'
            label='Datahub ID'
            disabled='true'
        />

        <x-twill::multi-select
            name='siteTags'
            label='Tags'
            placeholder='Select some tags'
            :options='$siteTagsList'
        />
    </a17-fieldset>
    <a17-fieldset id="related" title="Related">
        @formField('browser', [
            'routePrefix' => 'exhibitionsEvents',
            'max' => 4,
            'name' => 'exhibitions',
            'label' => 'Related exhibitions'
        ])

        @formField('browser', [
            'routePrefix' => 'exhibitionsEvents',
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

        <x-twill::input
            name='product_section_title'
            label='Shop section title'
            note='Defaults to "Related Products" if blank'
        />

        <x-twill::input
            name='product_section_title_link_label'
            label='Shop link label'
            note='Defaults to "Explore the shop" if blank'
        />

        <x-twill::input
            name='product_section_title_link_href'
            label='Shop link URL'
            note='Defaults to "https://shop.artic.edu" if blank'
        />

        @formField('browser', [
            'routePrefix' => 'general',
            'name' => 'shopItems',
            'moduleName' => 'shopItems',
            'label' => 'Shop items',
            'max' => 5,
        ])
    </a17-fieldset>

    @component('twill.partials.featured-related', ['form_fields' => $form_fields, 'autoRelated' => $autoRelated])
        @slot('routePrefix', 'exhibitionsEvents')
        @slot('moduleName', 'exhibitions')
    @endcomponent

    @include('twill.partials.related')

    @include('twill.partials.meta')

    <a17-fieldset id="api" title="Datahub fields">
        <x-twill::input
            name='title'
            label='Title'
            disabled='true'
        />
        <x-twill::input
            name='description'
            label='Description'
            type='textarea'
            disabled='true'
        />
        <x-twill::input
            name='short_description'
            label='Short description'
            type='textarea'
            disabled='true'
        />
        <x-twill::input
            name='status'
            label='Status'
            disabled='true'
        />
        <x-twill::input
            name='lake_guid'
            label='DAMS GUID'
            disabled='true'
        />
        <x-twill::input
            name='department_id'
            label='Department ID'
            disabled='true'
        />
        <x-twill::input
            name='gallery_title'
            label='Gallery'
            disabled='true'
        />
        <x-twill::input
            name='gallery_id'
            label='Gallery ID'
            disabled='true'
        />
        <x-twill::input
            name='type'
            label='Type'
            disabled='true'
        />
        <x-twill::input
            name='updated_at'
            label='Updated at'
            disabled='true'
        />
        <x-twill::input
            name='artwork_ids'
            label='Artwork IDs'
            disabled='true'
        />
        <x-twill::input
            name='venue_ids'
            label='Venue IDs'
            disabled='true'
        />
        <x-twill::input
            name='site_ids'
            label='Site IDs'
            disabled='true'
        />
        <x-twill::input
            name='event_ids'
            label='Event IDs'
            disabled='true'
        />
    </a17-fieldset>
@stop
