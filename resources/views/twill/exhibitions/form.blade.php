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

    <x-twill::formColumns>
        <x-slot:left>
            <x-twill::date-picker
                name='public_start_date'
                label='Public Start Date'
                withTime='false'
                placeholder='{{ isset($item) && $item->aic_start_at ? (new \Carbon\Carbon($item->aic_start_at))->toFormattedDateString() : null }}'
            />
        </x-slot:left>
        <x-slot:right>
            <x-twill::date-picker
                name='public_end_date'
                label='Public End Date'
                withTime='false'
                placeholder='{{ isset($item) && $item->aic_end_at ? (new \Carbon\Carbon($item->aic_end_at))->toFormattedDateString() : null }}'
            />
        </x-slot:right>
    </x-twill::formColumns>

    <x-twill::formColumns>
        <x-slot:left>
            <x-twill::date-picker
                name='member_preview_start_date'
                label='Member Preview Start Date'
                withTime='false'
                placeholder=''
            />
        </x-slot:left>
        <x-slot:right>
            <x-twill::date-picker
                name='member_preview_end_date'
                label='Member Preview End Date'
                withTime='false'
                placeholder=''
            />
        </x-slot:right>
    </x-twill::formColumns>

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

    @php
        $blocks = BlockHelpers::getBlocksForEditor([
            'paragraph', 'image', 'hr', 'artwork', 'split_block', 'gallery_new', 'link', 'video', 'quote', 'tour_stop', 'accordion', 'media_embed', 'list', 'timeline', 'button', 'newsletter_signup_inline', 'audio_player', '360_embed', 'mirador_embed', 'event', 'feature_2x', 'layered_image_viewer', '3d_model', 'feature_4x', 'mobile_app', 'mirador_modal', '360_modal'
        ]);
    @endphp

    <x-twill::block-editor
        :blocks='$blocks'
    />
@stop

@section('fieldsets')
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

    <x-twill::formFieldset id="waitTime" title="Wait time">
        <x-twill::browser
            name='waitTimes'
            label='Wait Time'
            note='Select a queue to display the wait time for'
            route-prefix='exhibitionsEvents'
            module-name='waitTimes'
            :max='1'
        />

        <x-twill::wysiwyg
            name='wait_time_override'
            label='Wait time copy'
            note='Content will display below wait time data'
            :maxlength='255'
            :toolbar-options="[ 'italic' ]"
        />
    </x-twill::formFieldset>

    <x-twill::formFieldset id="attributes" title="Attributes">
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
    </x-twill::formFieldset>
    <x-twill::formFieldset id="related" title="Related">
        <x-twill::browser
            name='exhibitions'
            label='Related exhibitions'
            route-prefix='exhibitionsEvents'
            :max='4'
        />

        <x-twill::browser
            name='events'
            label='Related events'
            note='Select related events'
            route-prefix='exhibitionsEvents'
            module-name='events'
            :max='20'
        />
    </x-twill::formFieldset>

    <x-twill::formFieldset id="offers" title="Offers and Products">
        <x-twill::repeater
            type="offers"
        />

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

        <x-twill::browser
            name='shopItems'
            label='Shop items'
            route-prefix='general'
            module-name='shopItems'
            :max='5'
        />
    </x-twill::formFieldset>

    @component('twill.partials.featured-related', ['form_fields' => $form_fields, 'autoRelated' => $autoRelated])
        @slot('routePrefix', 'exhibitionsEvents')
        @slot('moduleName', 'exhibitions')
    @endcomponent

    @include('twill.partials.related')

    @include('twill.partials.meta')

    <x-twill::formFieldset id="api" title="Datahub fields">
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
    </x-twill::formFieldset>
@stop
