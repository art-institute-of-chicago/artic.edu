@extends('twill::layouts.form')

@section('contentFields')
    <x-twill::input
        name='title'
        label='Title'
    />
@stop

@section('fieldsets')
    <x-twill::formFieldset title="Navigation Menu" id="conservationAndScience-nav-menu">
        <x-twill::repeater
            type="menu_items"
        />
    </x-twill::formFieldset>
    <x-twill::formFieldset title="Custom Content" id="conservationAndScience-custom_content">
        @php
            $blocks = [
                'editorial_block',
                'event',
                'gallery_new',
                'image_slider',
                'showcase',
                'list',
                'hr',
            ];
        @endphp
        <x-twill::block-editor
            name='default'
            :blocks='$blocks'
            withoutSeparator='true'
        />
    </x-twill::formFieldset>
    <x-twill::formFieldset title="FAQs" id="conservationAndScience-faq">
        <x-twill::repeater
            type='faqs'
        />
    </x-twill::formFieldset>
    <x-twill::formFieldset id="conservationAndScience-metadata" title="Overwrite default metadata (optional)">
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
