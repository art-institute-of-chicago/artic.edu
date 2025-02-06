@extends('twill::layouts.form', [
    'additionalFieldsets' => [
        ['fieldset' => 'hours', 'label' => 'Hours'],
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
        'blocks' => BlockHelpers::getBlocksForEditor([
            'paragraph', 'image', 'hr', 'artwork', 'split_block', 'gallery_new', 'link', 'video', 'tour_stop', 'accordion', 'ranged_accordion', 'media_embed', 'list', 'timeline', 'child_pages', 'grid', 'button', 'newsletter_signup_inline', 'table', 'audio_player', 'mirador_embed', 'custom_banner', 'search_bar', 'membership_banner', '3d_model', 'mobile_app', 'mirador_modal'
        ])
    ])
@stop

@section('fieldsets')
    <a17-fieldset id="hours" title="Hours">
        @formField('checkbox', [
            'name'  => 'show_hours',
            'label' => 'Select to display museum hours on the page',
        ])

        <p>The page must have a banner image in order to display museum hours.</p>
    </a17-fieldset>

    @component('twill.partials.featured-related', ['form_fields' => $form_fields, 'autoRelated' => $autoRelated])
        @slot('routePrefix', 'generic')
        @slot('moduleName', 'genericPages')
    @endcomponent

    <a17-fieldset id="sponsors" title="Sponsors">
        @formField('browser', [
            'routePrefix' => 'exhibitionsEvents',
            'moduleName' => 'sponsors',
            'name' => 'sponsors',
            'label' => 'Sponsors',
            'note' => 'Display content blocks from this sponsor',
            'max' => 1
        ])
    </a17-fieldset>

    {{-- WEB-2236: Use 'twill.partials.meta' as a component --}}
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
