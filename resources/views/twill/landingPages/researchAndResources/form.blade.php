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

<a17-fieldset title="Research Content" id="research_content">

    <x-twill::input
        name='labels.resources_landing_title'
        label='Title'
    />

    <x-twill::input
        name='labels.resources_landing_intro'
        label='Intro text'
        type='textarea'
    />

    <x-twill::medias
        name='research_landing_image'
        label='Hero image'
    />

    <x-twill::browser
        name='researchResourcesFeaturePages'
        label='Featured pages'
        route-prefix='generic'
        module-name='genericPages'
        :max='9'
    />

    <x-twill::browser
        name='researchResourcesStudyRooms'
        label='Study room pages'
        route-prefix='generic'
        module-name='genericPages'
        :max='3'
    />

    <x-twill::browser
        name='researchResourcesStudyRoomMore'
        label='Study room more link'
        route-prefix='generic'
        module-name='genericPages'
        :max='1'
    />

</a17-fieldset>

<a17-fieldset title="Custom Content" id="custom_content">

    @formField('block_editor', [
        'blocks' => BlockHelpers::getBlocksForEditor([
            'paragraph', 'image', 'image', 'hr', 'hr', 'artwork', 'split_block', 'split_block', 'gallery_new', 'video', 'video', 'quote', 'quote', 'tour_stop', 'tour_stop', 'media_embed', 'media_embed', 'list', 'grid', 'grid', 'image_slider', 'button', 'audio_player', '360_embed', 'mirador_embed', '3d_embed', 'membership_banner', 'membership_banner', 'showcase', '3d_tour', '3d_model', 'stories_block', 'citation', 'mobile_app', 'mirador_modal', 'digital_label', '360_modal'
        ])
    ])

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
