@extends('twill::layouts.form')

@push('extra_css')
    <style>
        #content .articles-index-link {
            font-weight: bold;
            margin-top: 1em;
        }
    </style>
@endPush

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

    <x-twill::checkbox
        name='is_dsc_stub'
        label='This page is a stub that links out to publications.artic.edu'
    />
@stop

@section('fieldsets')
    <x-twill::formConnectedFields
        field-name='is_dsc_stub'
        field-values="true"
    >
        @formFieldset([
            'id' => 'fields_for_dsc_stub',
            'title' => 'DSC Stub Fields',
        ])
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
        @endformFieldset
    </x-twill::formConnectedFields>

    @formFieldset([
        'id' => 'fields_for_full_publication',
        'title' => 'Publication Fields',
    ])
        <x-twill::wysiwyg
            name='welcome_note_display'
            label='Welcome note text'
            :toolbar-options="[ 'italic' ]"
        />

        <x-twill::browser
            name='welcome_note_section'
            label='Welcome note section'
            :max='1'
            :modules="[
                [
                    'name' => route('twill.collection.articlesPublications.digitalPublications.articles.subbrowser', [ 'digitalPublication' => $item->id, ])
                    'label' => 'Articles'
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
    @endformConnectedFields

    @include('twill.partials.related')

    @include('twill.partials.meta')

@endsection
