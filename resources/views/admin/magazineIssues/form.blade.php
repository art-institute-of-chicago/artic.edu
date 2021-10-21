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

        {{-- We cannot @include('admin.partials.hero') here, but let's keep parity with it! --}}

        @formField('wysiwyg', [
            'type' => 'textarea',
            'name' => 'hero_caption',
            'label' => 'Hero caption',
            'note' => 'Copyright for all images',
            'toolbarOptions' => [
                'italic', 'link',
            ],
        ])

        @formField('wysiwyg', [
            'type' => 'textarea',
            'name' => 'hero_text',
            'label' => 'Hero text',
            'toolbarOptions' => [
                'italic', 'link',
            ],
        ])

        @formField('medias', [
            'name' => 'hero',
            'label' => 'Hero images',
            'withAddInfo' => false,
            'withVideoUrl' => false,
            'withCaption' => false,
            'note' => 'Order should match links in header text',
            'max' => 20,
        ])

        @formField('medias', [
            'with_multiple' => false,
            'no_crop' => false,
            'label' => 'Mobile hero image',
            'name' => 'mobile_hero',
            'note' => 'Minimum image width 3000px'
        ])
    </a17-fieldset>

    <a17-fieldset id="welcome_note" title="Welcome Note">
        @formField('browser', [
            'routePrefix' => 'collection.articles_publications',
            'moduleName' => 'articles',
            'name' => 'welcome_note',
            'label' => 'Welcome note',
            'note' => 'Select one article',
        ])

        @formField('wysiwyg', [
            'name' => 'welcome_note_display',
            'label' => 'Preview text',
            'maxlength' => 255,
            'note' => 'If empty, we use the article\'s "List description"',
            'toolbarOptions' => [
                'italic'
            ],
        ])

        @formField('input', [
            'name' => 'welcome_note_author_override',
            'label' => 'Author override',
            'note' => 'If empty, we use the article\'s author logic'
        ])
    </a17-fieldset>

    <a17-fieldset id="content" title="Content">
        <p>For non-custom magazine items (Articles, Highlights, etc.), if there is no "List description" specified here, we will attempt to fallback to the "List description" field specified on that item's edit page.</p>

        @formField('block_editor', [
            'blocks' => BlockHelpers::getBlocksForEditor([
                'magazine_item',
                'events',
                'exhibitions',
                'magazine_call_to_action',
            ])
        ])
    </a17-fieldset>

@endsection
