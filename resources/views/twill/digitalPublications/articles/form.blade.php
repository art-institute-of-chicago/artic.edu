@extends('twill::layouts.form')

@section('contentFields')
    <x-twill::input
        name='title_display'
        label='Title formatting (optional)'
        note='Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
    />

    <x-twill::date-picker
        name='date'
        label='Display date'
        :required='true'
        withTime='false'
        note='Required'
    />

    <x-twill::select
        name='article_type'
        label='Type'
        placeholder='Select a type'
        default='text'
        :options='$types'
    />
    <x-twill::select
        name='listing_display'
        label='Listing display'
        placeholder='Select a listing display'
        default='default'
        :options="[
            ['value' => 'feature', 'label' => 'Feature'],
            ['value' => '3-across', 'label' => '3-Across'],
            ['value' => 'entries', 'label' => 'Entries'],
            ['value' => 'group_entries', 'label' => 'Group of Entries'],
            ['value' => 'list', 'label' => 'List view'],
            ['value' => 'simple_list', 'label' => 'Text list view'],
        ]"
    />

    <x-twill::formColumns>
        <x-slot:left>
            <x-twill::checkbox
                name='hide_title'
                label='Hide title in listing view'
            />
        </x-slot>

        <x-slot:right>
            <x-twill::checkbox
                name='suppress_listing'
                label='Hide from listing view'
            />
        </x-slot>
    </x-twill::formColumns>
@stop

@section('fieldsets')
    <x-twill::formFieldset id='editorial-content' title='Editorial Content'>
        <x-twill::formConnectedFields
            field-name='article_type'
            field-values="grouping"
            :render-for-blocks='false'
            :keep-alive='true'
        >
            <x-twill::wysiwyg
                name='grouping_description'
                label='Description'
                note='Max 255 characters'
                :maxlength='255'
                :toolbar-options="[ 'italic', 'link' ]"
            />

            <x-twill::medias
                name='grouping_hero'
                label='Grouping image'
                note='Minimum image width 3000px'
            />

            <x-twill::medias
                name='grouping_mobile_hero'
                label='Mobile grouping image'
                note='Minimum image width 2000px'
            />
        </x-twill::formConnectedFields>

        <x-twill::formConnectedFields
            field-name='article_type'
            field-values="entry"
            :render-for-blocks='false'
            :keep-alive='true'
        >
            <x-twill::medias
                name='hero'
                label='Listing image'
                note='Minimum image width 3000px'
            />

            <x-twill::medias
                name='mobile_hero'
                label='Mobile listing image'
                note='Minimum image width 2000px'
            />

            <x-twill::input
                name='author_display'
                label='Author display'
                note="On Entry type articles, authorship is prepended with 'Entry by'"
            />

            <x-twill::browser
                name='authors'
                label='Authors'
                note="On Entry type articles, authorship is prepended with 'Entry by'"
                route-prefix='collection'
                module-name='authors'
                :max='10'
            />
        </x-twill::formConnectedFields>

        <x-twill::formConnectedFields
            field-name='article_type'
            :field-values="['about', 'text', 'work']"
            :render-for-blocks='false'
            :keep-alive='true'
        >

            <x-twill::medias
                name='hero'
                label='Hero image'
                note='Minimum image width 3000px'
            />

            <x-twill::medias
                name='mobile_hero'
                label='Mobile hero image'
                note='Minimum image width 2000px'
            />

            <x-twill::input
                name='author_display'
                label='Author display'
            />

            <x-twill::browser
                name='authors'
                label='Authors'
                route-prefix='collection'
                module-name='authors'
                :max='10'
            />

        </x-twill::formConnectedFields>

        <x-twill::formConnectedFields
            field-name='article_type'
            field-values="grouping"
            :is-equal='false'
            :render-for-blocks='false'
            :keep-alive='true'
        >
            <x-twill::input
                name='label'
                label='Article label'
                note='Used in the "eyebrow" of cards on the publication page'
            />

            <x-twill::wysiwyg
                name='list_description'
                label='List description'
                note='Max 255 characters. Will be used on the main landing, search, and social media.'
                :maxlength='255'
                :toolbar-options="[ 'italic' ]"
            />

            <x-twill::wysiwyg
                name='cite_as'
                label='How to Cite'
                :toolbar-options="[ 'italic' ]"
            />

            <x-twill::wysiwyg
                name='references'
                label='References'
                :toolbar-options="[ 'italic', 'link', 'list-ordered', 'list-unordered' ]"
            />

            @php
                $blocks = BlockHelpers::getBlocksForEditor([
                    '360_embed',
                    '360_modal',
                    '3d_embed',
                    '3d_model',
                    '3d_tour',
                    'ranged_accordion',
                    'artwork',
                    'audio_player',
                    'button',
                    'citation',
                    'digital_label',
                    'gallery_new',
                    'hr',
                    'image',
                    'image_slider',
                    'layered_image_viewer',
                    'links-bar',
                    'list',
                    'media_embed',
                    'membership_banner',
                    'mirador_embed',
                    'mirador_modal',
                    'mobile_app',
                    'paragraph',
                    'quote',
                    'split_block',
                    'table',
                    'tombstone',
                    'tour_stop',
                    'video',
                ]);
            @endphp

            <x-twill::block-editor
                :blocks='$blocks'
            />
        </x-twill::formConnectedFields>

    </x-twill::formFieldset>

    @include('twill.partials.meta')
@stop
