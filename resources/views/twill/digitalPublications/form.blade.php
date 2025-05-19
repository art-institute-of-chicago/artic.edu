@extends('twill::layouts.form')

@push('extra_css')
    <style>
        #content .articles-index-link {
            font-weight: bold;
            margin-top: 1em;
        }
    </style>
@endPush

@section('sideFieldset')
    <x-twill::checkbox
        name='is_unlisted'
        label="Don't show this digital publication in listings"
    />
@endsection

@section('contentFields')
    <div class="articles-index-link">
        <a href="{{ route('twill.collection.articlesPublications.digitalPublications.articles.index', [$item->id]) }}">
            {{ $item->articles->count() }} articles
        </a>
    </div>

    <x-twill::wysiwyg
        name='header_subtitle_display'
        label='Subtitle for header'
        :toolbar-options="[ 'italic' ]"
    />

    <x-twill::medias
        name='listing'
        label='Hero image'
        note='Minimum image width 3000px'
    />

    <x-twill::medias
        name='mobile_listing'
        label='Hero image, mobile'
        note='Minimum image width 2000px'
    />

    <x-twill::medias
        name='publications_listing'
        label='Publications listing image'
        note='Minimum image width 3000px'
    />

    @formField('color_select', [
        'name' => 'bgcolor',
        'label' => 'Hero background color',
        'options' => $heroBackgroundColors,
        'columns' => 3,
    ])

    <x-twill::wysiwyg
        type='textarea'
        name='hero_caption'
        label='Hero image caption'
        note='Usually used for copyright'
        :maxlength='255'
        :toolbar-options="[ 'italic', 'link' ]"
    />

    <x-twill::wysiwyg
        name='listing_description'
        label='Listing description'
        :maxlength='300'
        :toolbar-options="[ 'italic' ]"
    />

    <x-twill::date-picker
        name='publication_date'
        label='Publication date'
        withTime='false'
    />

    <x-twill::multi-select
        name='categories'
        label='Categories'
        placeholder='Select some categories'
        unpack='true'
        :options='$categoriesList'
    />

    <x-twill::checkbox
        name='is_dsc_stub'
        label='This page is a stub that links out to publications.artic.edu'
    />
@stop

@section('fieldsets')
    <x-twill::formConnectedFields
        field-name='is_dsc_stub'
        :field-values="true"
        :keep-alive='true'
    >
        <x-twill::formFieldset id='fields_for_dsc_stub' title='DSC Stub Fields'>
            <p style="margin-bottom: -20px">This content is only shown when the page is a DSC stub.</p>
            <hr>

            <x-twill::medias
                name='banner'
                label='Banner image'
                note='Minimum image width 3000px'
            />

            @php
                $blocks = BlockHelpers::getBlocksForEditor([
                    '3d_model',
                    'accordion',
                    'hr',
                    'image',
                    'link',
                    'list',
                    'media_embed',
                    'membership_banner',
                    'newsletter_signup_inline',
                    'paragraph',
                    'split_block',
                    'timeline',
                    'video',
                ]);
            @endphp

            <x-twill::block-editor
                :blocks='$blocks'
            />

        </x-twill::formFieldset>
    </x-twill::formConnectedFields>

    <x-twill::formFieldset id='fields_for_full_publication' title='Publication Fields'>
        <x-twill::wysiwyg
            name='welcome_note_display'
            label='Welcome note text'
            :toolbar-options="[ 'italic' ]"
        />

        <x-twill::browser
            name='welcome_note_section'
            label='Welcome note section'
            :max='1'
            :endpoints="[
                [
                    'label' => 'Articles',
                    'value' => '/collection/articlesPublications/digitalPublicationsBrowser/articles/browser?digitalPublication=' . $item->id
                ]
            ]"
    />

        <x-twill::wysiwyg
            name='sponsor_display'
            label='Sponsors'
            :toolbar-options="[ 'italic' ]"
        />

        <x-twill::wysiwyg
            name='cite_as'
            label='How to Cite'
            :toolbar-options="[ 'italic' ]"
        />

    </x-twill::formFieldset>

    @include('twill.partials.related')

    @include('twill.partials.meta')

@endsection
