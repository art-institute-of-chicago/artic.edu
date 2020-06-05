@extends('twill::layouts.form', [
    'disableContentFieldset' => true,
    'additionalFieldsets' => [
        ['fieldset' => 'header', 'label' => 'Header'],
        ['fieldset' => 'welcome_note', 'label' => 'Welcome Note'],
        ['fieldset' => 'content', 'label' => 'Content'],
    ]
])

@section('fieldsets')

    <a17-fieldset id="header" title="Header">

        @formField('wysiwyg', [
            'name' => 'list_description',
            'label' => 'List description',
            'maxlength' => 255,
            'note' => 'Max 255 characters. Will be used for social media.',
            'toolbarOptions' => [
                'italic'
            ],
        ])

        @include('admin.partials.hero')

        @formField('wysiwyg', [
            'type' => 'textarea',
            'name' => 'hero_text',
            'label' => 'Hero text',
            'toolbarOptions' => [
                'italic', 'link',
            ],
        ])
    </a17-fieldset>

    <a17-fieldset id="welcome_note" title="Welcome Note">
        @formField('browser', [
            'routePrefix' => 'collection.articles_publications',
            'moduleName' => 'articles',
            'name' => 'welcome_note',
            'label' => 'Welcome Note',
            'note' => 'Select one article',
        ])

        @formField('wysiwyg', [
            'name' => 'welcome_note_display',
            'label' => 'Preview Text',
            'maxlength' => 255,
            'note' => 'If empty, we use the article\'s "List description"',
            'toolbarOptions' => [
                'italic'
            ],
        ])

        <p>For the attribution, we use the "Author Display" field from the linked article.</p>
    </a17-fieldset>

    <a17-fieldset id="content" title="Content">
        <p>For non-custom magazine items (Articles, Highlights, etc.), if there is no "List description" specified here, we will attempt to fallback to the "List description" field specified on that item's edit page.</p>

        @formField('block_editor', [
            'blocks' => getBlocksForEditor([
                'magazine_item',
                'events',
                'exhibitions',
                'magazine_call_to_action',
            ])
        ])
    </a17-fieldset>

@endsection
