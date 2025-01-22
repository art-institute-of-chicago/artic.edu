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

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'header_variation',
    'fieldValues' => ['default', 'small', 'cta'],
    'renderForBlocks' => false
])

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

@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'header_variation',
    'fieldValues' => 'cta',
    'renderForBlocks' => false
])

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

@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'header_variation',
    'fieldValues' => 'feature',
    'renderForBlocks' => false
])

    <x-twill::browser
        name='primaryFeatures'
        label='Main feature'
        note='Queue up to 3 home features for the large hero area'
        route-prefix='generic'
        module-name='pageFeatures'
        :max='3'
    />

@endcomponent

@stop

@section('fieldsets')

<a17-fieldset title="Navigation Menu" id="visit_nav-menu">

    <x-twill::input
        name='labels.visit_nav_buy_tix_label'
        label='Tickets Label'
    />

    <x-twill::input
        name='labels.visit_nav_buy_tix_link'
        label='Tickets Link'
    />

</a17-fieldset>

<a17-fieldset title="Hours" id="visit_hours">

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

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'is_custom_hours',
        'fieldValues' => true
    ])
        @formField('repeater', ['type' => 'featured_hours'])
    @endcomponent
</a17-fieldset>

<a17-fieldset title="Admission" id="visit_admission">
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
</a17-fieldset>

<a17-fieldset title="Location" id="visit_hours">
    <x-twill::medias
        name='visit_map'
        label='Map Image'
        note='Minimum image width 3000px'
    />

    @formField('repeater', ['type' => 'locations', 'max' => 2])

    <x-twill::input
        name='labels.visit_parking_label'
        label='Parking Button Label'
    />

    <x-twill::input
        name='labels.visit_parking_link'
        label='Parking Button Link'
    />
</a17-fieldset>

<a17-fieldset title="Custom Content" id="custom_content">

    @formField('block_editor', [
        'blocks' => BlockHelpers::getBlocksForEditor([
            '3d_embed',
            '3d_model',
            '3d_tour',
            '360_embed',
            '360_modal',
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
            'membership_banner',
            'mirador_embed',
            'mirador_modal',
            'paragraph',
            'quote',
            'showcase',
            'split_block',
            'stories_block',
            'tour_stop',
            'video',
            'vtour_embed'
        ])
    />

</a17-fieldset>

<a17-fieldset title="FAQs" id="faq">
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

    @formField('repeater', ['type' => 'faqs'])
</a17-fieldset>

<a17-fieldset id="metadata" title="Overwrite default metadata (optional)">
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
</a17-fieldset>

@stop
