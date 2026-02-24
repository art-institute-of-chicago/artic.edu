@extends('twill::layouts.form')

@section('contentFields')

<x-twill::select
    name='header_variation'
    label='Header Style'
    placeholder='Select style of page header'
    default='default'
    :options="[
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
            'label' => 'Featured Content'
        ]
    ]"
/>

<hr/>

<x-twill::formConnectedFields
    field-name='header_variation'
    :field-values="['default', 'small', 'cta']"
    :render-for-blocks='false'
    :keep-alive='true'
>

    <x-twill::medias
        name='hero'
        label='Hero image'
        note='Minimum image width 3000px'
    />

    <x-twill::files
        name='video'
        label='Hero video'
        note='Add an MP4 file'
    />

    <x-twill::medias
        name='mobile_hero'
        label='Hero image, mobile'
        note='Minimum image width 2000px'
    />

</x-twill::formConnectedFields>

<x-twill::formConnectedFields
    field-name='header_variation'
    field-values="cta"
    :render-for-blocks='false'
    :keep-alive='true'
>

    <x-twill::input
        name='header_cta_title'
        label='CTA Title'
    />

    <x-twill::input
        name='header_cta_button_label'
        label='Button Label'
    />

    <x-twill::input
        name='header_cta_button_link'
        label='Button Link'
    />

</x-twill::formConnectedFields>

<x-twill::formConnectedFields
    field-name='header_variation'
    field-values="feature"
    :render-for-blocks='false'
>

    <x-twill::browser
        name='primaryFeatures'
        label='Main feature'
        note='Queue up to 3 home features for the large hero area'
        route-prefix='generic'
        module-name='pageFeatures'
        :max='3'
    />

</x-twill::formConnectedFields>

<x-twill::wysiwyg
    name='listing_description'
    label='Listing description'
    note='Max 255 characters'
    :maxlength="255"
    :toolbar-options="[ 'italic' ]"
/>

@stop

@section('fieldsets')

<x-twill::formFieldset title="Navigation Menu" id="visit_nav-menu">

    <x-twill::input
        name='labels.visit_nav_buy_tix_label'
        label='Tickets Label'
    />

    <x-twill::input
        name='labels.visit_nav_buy_tix_link'
        label='Tickets Link'
    />

</x-twill::formFieldset>

<x-twill::formFieldset title="Hours" id="visit_hours">

    <x-twill::wysiwyg
        name='labels.visit_members_intro'
        label='Member Intro'
        :toolbar-options="[ 'bold', 'italic', 'link' ]"
    />

    <x-twill::wysiwyg
        name='hour_intro'
        label='Hours Intro'
        :toolbar-options="[ 'bold', 'italic', 'link' ]"
    />

    <x-twill::checkbox
        name='is_custom_hours'
        label='Override default hours'
    />

    <x-twill::formConnectedFields
        field-name='is_custom_hours'
        :field-values='true'
    >
        <x-twill::repeater
            type="featured_hours"
        />
    </x-twill::formConnectedFields>
</x-twill::formFieldset>

<x-twill::formFieldset title="Admission" id="visit_admission">
    <x-twill::wysiwyg
        name='labels.visit_admission_intro'
        label='Admission Intro'
    />

    <x-twill::input
        name='labels.visit_admission_tix_label'
        label='Tickets Label'
    />

    <x-twill::input
        name='labels.visit_admission_tix_link'
        label='Tickets Link'
    />

    <x-twill::input
        name='labels.visit_admission_members_label'
        label='Member Label'
    />

    <x-twill::input
        name='labels.visit_admission_members_link'
        label='Member Link'
    />
</x-twill::formFieldset>

<x-twill::formFieldset title="Location" id="visit_hours">
    <x-twill::medias
        name='visit_map'
        label='Map Image'
        note='Minimum image width 3000px'
    />

    <x-twill::repeater
        type='locations'
        :max='2'
    />

    <x-twill::input
        name='labels.visit_parking_label'
        label='Parking Button Label'
    />

    <x-twill::input
        name='labels.visit_parking_link'
        label='Parking Button Link'
    />
</x-twill::formFieldset>

<x-twill::formFieldset title="Custom Content" id="custom_content">

    @php
        $blocks = BlockHelpers::getBlocksForEditor([
            '360_embed',
            '360_modal',
            '3d_embed',
            '3d_model',
            '3d_tour',
            'artwork',
            'audio_player',
            'button',
            'citation',
            'collection_block',
            'custom_banner',
            'digital_label',
            'feature_block',
            'featured_pages_grid',
            'gallery_new',
            'grid',
            'hr',
            'image',
            'image_slider',
            'media_embed',
            'mirador_embed',
            'mirador_modal',
            'paragraph',
            'quote',
            'showcase',
            'split_block',
            'stories_block',
            'tour_stop',
            'video',
        ]);
    @endphp

    <x-twill::block-editor
        :blocks='$blocks'
    />

</x-twill::formFieldset>

<x-twill::formFieldset title="FAQs" id="faq">
    <x-twill::input
        name='labels.visit_faqs_label'
        label='More FAQs Label'
    />

    <x-twill::input
        name='labels.visit_faqs_link'
        label='More FAQs Link'
    />

    <x-twill::input
        name='labels.visit_faq_more_link'
        label="More FAQs and guidelines link"
    />

    <x-twill::repeater
        type="faqs"
    />
</x-twill::formFieldset>

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

    <p>Comma-separated list of words or phrases. Don't worry about grammar or similar word variations. This field is intended to assist our internal search engine in finding your content. These tags will not be shown to website users and will have no effect on external search engines, e.g. Google.</p>
</x-twill::formFieldset>

@stop
