@extends('twill::layouts.form')
@section('contentFields')
    <x-twill::input
        name='title'
        label='Title'
    />
    <x-twill::input
        name='intro'
        label='Intro'
    />
    <x-twill::select
        name='header_variation'
        label='Header Style'
        placeholder='Select style of page header'
        default='default'
        :options="[
            [
                'value' => 'default',
                'label' => 'Default',
            ],
            [
                'value' => 'small',
                'label' => 'Small Image',
            ],
            [
                'value' => 'cta',
                'label' => 'Call to action',
            ],
            [
                'value' => 'feature',
                'label' => 'Featured Content',
            ]
        ]"
    />
    <hr/>
    <x-twill::formConnectedFields
        field-name='header_variation'
        :field-values="['default', 'small', 'cta']",
        :render-for-blocks='false'
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
    <x-twill::formFieldset title="Navigation Menu" id="nav-menu">
        <x-twill::repeater
            type="menu_items"
        />
    </x-twill::formFieldset>
    <x-twill::formFieldset title="Hours" id="hours">
        <x-twill::input
            name='hour_header'
            label='Hour Header'
        />
        <x-twill::wysiwyg
            name='hour_intro'
            label='Hour Intro'
            :toolbar-options="[ 'bold', 'italic', 'link' ]"
        />
        <x-twill::checkbox
            name='is_custom_hours'
            label='Override default hours'
        />
        <x-twill::formConnectedFields
            field-name='is_custom_hours'
            field-values='true'
        >
            <x-twill::repeater
                type="featured_hours"
            />
        </x-twill::formConnectedFields>
    </x-twill::formFieldset>
    <x-twill::formFieldset title="Location" id="location">
        <x-twill::input
            name='labels.location_header'
            label='Location Header'
        />
        <x-twill::medias
            name='rlc_location'
            label='Location Image'
        />
        <x-twill::wysiwyg
            name='labels.location_intro'
            label='Location Intro'
            :toolbar-options="[ 'bold', 'italic', 'link' ]"
        />
        <x-twill::input
            name='labels.directions_label'
            label='Directions Label'
        />
        <x-twill::input
            name='labels.directions_link'
            label='Directions Link'
        />
        <x-twill::input
            name='labels.visit_museum_button_label'
            label='Visit Museum Button Label'
        />
        <x-twill::input
            name='labels.visit_museum_button_link'
            label='Visit Museum Button Link'
        />
    </x-twill::formFieldset>
    <x-twill::formFieldset title="Custom Content" id="custom_content">
        @php
            $blocks = [
                'showcase',
                'showcase_multiple',
            ];
        @endphp

        <x-twill::block-editor
            name='default'
            :blocks='$blocks'
            withoutSeparator='true'
        />
    </x-twill::formFieldset>
    <x-twill::formFieldset title="Contact" id="contact">
        <x-twill::input
            name='labels.contact_header'
            label='Contact Header'
        />
        <x-twill::wysiwyg
            name='labels.contact_intro'
            label='Contact Intro'
            :toolbar-options="[ 'bold', 'italic' ]"
        />

        @php
            $blocks = [
                'newsletter_signup_inline',
                'paragraph',
            ];
        @endphp

        <x-twill::block-editor
            name='contact'
            :blocks='$blocks'
            withoutSeparator='true'
        />
    </x-twill::formFieldset>
    <x-twill::formFieldset title="FAQs" id="faq">
        <x-twill::repeater
            type='faqs'
        />
    </x-twill::formFieldset>
    <x-twill::formFieldset title="Donor Information" id="donor_info">
        @php
            $blocks = [
                'paragraph',
            ];
        @endphp

        <x-twill::block-editor
            name='donor_info'
            :blocks='$blocks'
            withoutSeparator='true'
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
