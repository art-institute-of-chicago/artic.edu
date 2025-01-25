@extends('twill::layouts.form', [
    'disableContentFieldset' => true,
    'additionalFieldsets' => [
        ['fieldset' => 'header', 'label' => 'Header'],
        ['fieldset' => 'welcome_note', 'label' => 'Welcome Note'],
        ['fieldset' => 'content', 'label' => 'Content'],
    ]
])

@section('fieldsets')

    <x-twill::formFieldset id="header" title="Header">

        <x-twill::wysiwyg
            name='list_description'
            label='List description'
            note='Max 255 characters. Will be used for social media.'
            :maxlength="255"
            :toolbar-options="[ 'italic' ]"
        />

        {{-- We cannot @include('twill.partials.hero') here, but lets keep parity with it! --}}

        <x-twill::wysiwyg
            type='textarea'
            name='hero_caption'
            label='Hero caption'
            note='Copyright for all images'
            :toolbar-options="[ 'italic', 'link' ]"
        />

        <x-twill::wysiwyg
            type='textarea'
            name='hero_text'
            label='Hero text'
            :toolbar-options="[ 'italic', 'link' ]"
        />

        <x-twill::medias
            name='hero'
            label='Hero images'
            note='Order should match links in header text'
            :withAddInfo='false'
            :withVideoUrl='false'
            :withCaption='false'
            :max='20'
        />

        <x-twill::medias
            name='mobile_hero'
            label='Mobile hero image'
            note='Minimum image width 3000px'
        />
    </x-twill::formFieldset>

    <x-twill::formFieldset id="welcome_note" title="Welcome Note">
        <x-twill::browser
            name='welcome_note'
            label='Welcome note'
            note='Select one article'
            route-prefix='collection.articlesPublications'
            module-name='articles'
        />

        <x-twill::wysiwyg
            name='welcome_note_display'
            label='Preview text'
            note="If empty, we use the article's 'List description'"
            :maxlength="255"
            :toolbar-options="[ 'italic' ]"
        />

        <x-twill::input
            name='welcome_note_author_override'
            label='Author override'
            note="If empty, we use the article's author logic"
        />
    </x-twill::formFieldset>

    <x-twill::formFieldset id="content" title="Content">
        <p>For non-custom magazine items (Articles, Highlights, etc.), if there is no "List description" specified here, we will attempt to fallback to the "List description" field specified on that item's edit page.</p>

        @php
            $blocks = BlockHelpers::getBlocksForEditor([
                'exhibitions', 'events', 'magazine_item', 'magazine_call_to_action'
            ]);
        @endphp

        <x-twill::block-editor
            :blocks='$blocks'
        />
    </x-twill::formFieldset>

@endsection
