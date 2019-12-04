@extends('twill::layouts.form', [
    'additionalFieldsets' => [
        ['fieldset' => 'side_related', 'label' => 'Sidebar Related'],
        ['fieldset' => 'metadata', 'label' => 'Metadata'],
    ]
])

@section('contentFields')
    @formField('input', [
        'name' => 'title_display',
        'label' => 'Title formatting (optional)',
        'note' => 'Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'label' => 'Banner image',
        'name' => 'banner',
        'note' => 'Minimum image width 2000px'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'label' => 'Listing image',
        'name' => 'listing',
        'note' => 'Minimum image width 3000px'
    ])

    @formField('wysiwyg', [
        'name' => 'listing_description',
        'label' => 'Listing description',
        'maxlength'  => 255,
        'note' => 'Max 255 characters',
        'toolbarOptions' => [
            'italic'
        ],
    ])

    @formField('wysiwyg', [
        'name' => 'short_description',
        'label' => 'Short description',
        'maxlength' => 255,
        'note' => 'Max 255 characters',
        'toolbarOptions' => [
            'italic'
        ],
    ])

    @formField('multi_select', [
        'name' => 'categories',
        'label' => 'Categories',
        'options' => $categoriesList,
        'placeholder' => 'Select some categories',
    ])

    @formField('input', [
        'name' => 'redirect_url',
        'label' => 'Redirect URL',
    ])

    @formField('checkbox', [
        'name'  => 'is_redirect_url_external',
        'label' => 'Is Redirect URL external?',
    ])

    @formField('checkbox', [
        'name'  => 'http_protected',
        'label' => 'Authentication required?',
    ])

    @formField('block_editor', [
        'blocks' => getBlocksForEditor([
            'paragraph', 'image', 'video', 'gallery', 'media_embed', 'list',
            'child_pages', 'accordion', 'membership_banner', 'timeline',
            'link', 'newsletter_signup_inline', 'artwork', 'artworks',
            'hr', 'split_block', 'search_bar', 'tour_stop', 'button',
            'mobile_app', 'grid', 'table',
        ])
    ])
@stop

@section('fieldsets')
    @component('admin.partials.featured-related')
        @slot('articles', 'articles')
        @slot('events', 'events')
        @slot('exhibitions', 'exhibitions')
        @slot('experiences', null)
        @slot('videos', null)
    @endcomponent

    {{-- TODO: Use 'admin.partials.meta' as a component --}}
    <a17-fieldset id="metadata" title="Overwrite default metadata (optional)">
        @formField('input', [
            'name' => 'meta_title',
            'label' => 'Metadata Title'
        ])

        @formField('input', [
            'name' => 'meta_description',
            'label' => 'Metadata Description',
            'type' => 'textarea'
        ])

        @formField('input', [
            'name' => 'search_tags',
            'label' => 'Internal Search Tags',
            'type' => 'textarea'
        ])

        <p>Comma-separatated list of words or phrases. Don't worry about grammar or similar word variations. This field is intended to assist our internal search engine in finding your content. These tags will not be shown to website users and will have no effect on external search engines, e.g. Google.</p>

    </a17-fieldset>

@stop
