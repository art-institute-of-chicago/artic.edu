@extends('twill::layouts.form')

@section('contentFields')
    <br /><strong><a href="{{ url('/collection/articles_publications/digitalPublications/' . $item->id . '/articles') }}">{{ $item->articles->count() }} Articles</a></strong>

    @formField('input', [
        'name' => 'title_display',
        'label' => 'Title formatting (optional)',
        'note' => 'Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'label' => 'Hero image',
        'name' => 'listing',
        'note' => 'Minimum image width 3000px'
    ])

    @formField('color', [
        'name' => 'bgcolor',
        'label' => 'Hero background color',
    ])

    @formField('wysiwyg', [
        'type' => 'textarea',
        'name' => 'hero_caption',
        'label' => 'Hero image caption',
        'note' => 'Usually used for copyright',
        'maxlength' => 255,
        'toolbarOptions' => [
            'italic', 'link',
        ],
    ])

    @formField('wysiwyg', [
        'name' => 'listing_description',
        'label' => 'Listing description',
        'note' => 'Max 300 characters',
        'maxlength' => 300,
        'toolbarOptions' => [
            'italic'
        ],
    ])

    <hr>

    @formField('checkbox', [
        'name' => 'is_dsc_stub',
        'label' => 'This page is a stub that links out to publications.artic.edu',
    ])
@stop

@section('fieldsets')
    <a17-fieldset id="fields_for_dsc_stub" title="DSC Stub Fields">
        <p style="margin-bottom: -20px">This content is only shown when the page is a DSC stub.</p>

        <hr>

        @formField('medias', [
            'with_multiple' => false,
            'label' => 'Banner image',
            'name' => 'banner',
            'note' => 'Minimum image width 3000px'
        ])

        @formField('block_editor', [
            'blocks' => BlockHelpers::getBlocksForEditor([
                'paragraph', 'image', 'hr', 'split_block', 'link', 'video', 'accordion', 'media_embed', 'list', 'timeline', 'newsletter_signup_inline', 'membership_banner', '3d_model'])
        ])
    </a17-fieldset>

    <a17-fieldset id="fields_for_dsc_stub" title="Publication Fields">
        <p style="margin-bottom: -20px">These fields are shown for full-fledged publications.</p>

        <hr>

        @formField('wysiwyg', [
            'name' => 'header_title_display',
            'label' => 'Title lockup for header',
            'note' => 'Use Shift+Enter to add linebreak instead of starting a new paragraph',
            'toolbarOptions' => [
                'italic'
            ],
        ])

        @formField('wysiwyg', [
            'name' => 'header_subtitle_display',
            'label' => 'Subtitle lockup for header',
            'toolbarOptions' => [
                'italic'
            ],
        ])

        <hr>

        @formField('wysiwyg', [
            'name' => 'sidebar_title_display',
            'label' => 'Title lockup for sidebar',
            'toolbarOptions' => [
                'italic'
            ],
        ])

        <hr>

        @formField('wysiwyg', [
            'name' => 'welcome_note_display',
            'label' => 'Welcome note text',
            'toolbarOptions' => [
                'italic'
            ],
        ])

        @formField('browser', [
            'name' => 'welcome_note_section',
            'label' => 'Welcome note section',
            'endpoint' => route('admin.collection.articles_publications.digitalPublications.articles.subbrowser',[
                'digitalPublication' => $item->id,
            ]),
            'max' => 1,
        ])

        <hr>

        @formField('wysiwyg', [
            'name' => 'sponsor_display',
            'label' => 'Sponsors',
            'toolbarOptions' => [
                'italic'
            ],
        ])

        @formField('wysiwyg', [
            'name' => 'cite_as',
            'label' => 'How to Cite',
            'toolbarOptions' => [
                'italic'
            ],
        ])
    </a17-fieldset>

    @include('admin.partials.related')

    @include('admin.partials.meta')

@endsection
