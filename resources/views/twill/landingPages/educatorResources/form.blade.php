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

    <x-twill::wysiwyg
        name='header_cta_description'
        label='CTA Description'
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

<x-twill::formFieldset title="Search Box" id="search-top">

    <x-twill::formColumns>
        <x-slot:left>
            <x-twill::input
                name='labels.header_search_title'
                label='Search Title'
            />
        </x-slot:left>
        <x-slot:right>
            <x-twill::input
                name='labels.header_search_button_label'
                label='Search Button Label'
            />
        </x-slot:right>
    </x-twill::formColumns>

    <x-twill::formColumns>
        <x-slot:left>
            <x-twill::wysiwyg
                name='labels.header_search_description'
                label='Search Description'
            />
        </x-slot:left>
        <x-slot:right>
            <x-twill::input
                name='labels.header_search_button_link'
                label='Search Button Link'
            />
        </x-slot:right>
    </x-twill::formColumns>

</x-twill::formFieldset>

<x-twill::formFieldset title="Custom Content" id="custom_content">

    @formField('block_editor', [
        'blocks' => BlockHelpers::getBlocksForEditor([
            'collection_block',
            'custom_banner',
            'editorial_block',
            'feature_block',
            'featured_pages_grid',
            'grid',
            'hr',
            'image',
            'image_slider',
            'media_embed',
            'quote',
            'showcase',
            'split_block',
            'stories_block',
            'tag_banner',
            'video',
        ])
    ])

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
