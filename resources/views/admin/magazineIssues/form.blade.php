@extends('twill::layouts.form', [
    'disableContentFieldset' => true,
    'additionalFieldsets' => [
        ['fieldset' => 'title_and_image', 'label' => 'Title and Image'],
        ['fieldset' => 'editors_note', 'label' => 'Editor\'s Note'],
        ['fieldset' => 'content', 'label' => 'Content'],
    ]
])

@section('fieldsets')

    <a17-fieldset id="title_and_image" title="Title and Image">
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
    </a17-fieldset>

    <a17-fieldset id="editors_note" title="Editor's Note">
        <p>Lorem ipsum.</p>
        {{--
            TODO:
             - Browser for an article that'll serve as the editor's note
             - Text to display on the issue itself
             - Author display
        --}}
    </a17-fieldset>

    <a17-fieldset id="content" title="Content">
        <p>For non-custom magazine items (Articles, Highlights, etc.), if there is no "List description" specified here, we will attempt to fallback to the "List description" field specified on that item's edit page.</p>

        @formField('block_editor', [
            'blocks' => getBlocksForEditor([
                'magazine_item',
                // TODO: magazine events
                // TODO: magazine exhibitions
                // TODO: magazine cta
            ])
        ])
    </a17-fieldset>

@endsection
