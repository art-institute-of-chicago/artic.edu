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

@stop

@section('fieldsets')

@stop
