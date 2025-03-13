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
    :field-values="['default', 'small', 'cta']",
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

@stop

@section('fieldsets')

<x-twill::formFieldset title="Research Content" id="research_content">

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

</x-twill::formFieldset>

<x-twill::formFieldset title="Custom Content" id="custom_content">

    @php
        $blocks = BlockHelpers::getBlocksForEditor([
            'paragraph', 'image', 'image', 'hr', 'hr', 'artwork', 'split_block', 'split_block', 'gallery_new', 'video', 'video', 'quote', 'quote', 'tour_stop', 'tour_stop', 'media_embed', 'media_embed', 'list', 'grid', 'grid', 'image_slider', 'button', 'audio_player', '360_embed', 'mirador_embed', '3d_embed', 'membership_banner', 'membership_banner', 'showcase', '3d_tour', '3d_model', 'stories_block', 'citation', 'mobile_app', 'mirador_modal', 'digital_label', '360_modal'
        ]);
    @endphp

    <x-twill::block-editor
        :blocks='$blocks'
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

    <p>Comma-separatated list of words or phrases. Don't worry about grammar or similar word variations. This field is intended to assist our internal search engine in finding your content. These tags will not be shown to website users and will have no effect on external search engines, e.g. Google.</p>
</x-twill::formFieldset>

@stop
