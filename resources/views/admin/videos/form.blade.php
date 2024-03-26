@extends('twill::layouts.form', [
    'additionalFieldsets' => [
        ['fieldset' => 'content', 'label' => 'Content'],
        ['fieldset' => 'related_to', 'label' => 'Related'],
        ['fieldset' => 'metadata', 'label' => 'Metadata'],
    ]
])

@section('contentFields')
    @formField('input', [
        'name' => 'title_display',
        'label' => 'Title formatting (optional)',
        'note' => 'Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
    ])

    @formField('input', [
        'name' => 'video_url',
        'label' => 'Video URL'
    ])

    @formField('input', [
        'name' => 'duration',
        'label' => 'Duration',
        'note' => 'e.g. 3:45'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Hero Image',
        'name' => 'hero',
        'note' => 'Minimum image width 3000px'
    ])

    @formField('date_picker', [
        'name' => 'date',
        'label' => 'Display date',
        'note' => 'When was this video published?',
    ])

    @formField('wysiwyg', [
        'name' => 'list_description',
        'label' => 'List description',
        'maxlength' => 255,
        'note' => 'Max 255 characters. Will be used in "Related Videos" and social media.',
        'toolbarOptions' => [
            'italic'
        ],
    ])

    @formField('input', [
        'name' => 'heading',
        'label' => 'Heading',
        'rows' => 3,
        'type' => 'textarea',
    ])
    

    @formField('block_editor', [
        'blocks' => BlockHelpers::getBlocksForEditor([
            'paragraph', 'hr', 'artwork', 'split_block', 'quote', 'tour_stop', 'list', 'button', 'audio_player', 'membership_banner', 'mobile_app', 'artworks'
        ])
    ])
@stop

@section('fieldsets')

    <a17-fieldset id="related_to" title="Related">

        @formField('multi_select', [
            'name' => 'categories',
            'label' => 'Categories',
            'options' => $categoriesList,
            'placeholder' => 'Select some categories',
        ])

        <p>If this is left blank, we will show the four most recently published videos.</p>

        @formField('browser', [
            'routePrefix' => 'collection.articles_publications',
            'name' => 'related_videos',
            'moduleName' => 'videos',
            'label' => 'Related videos',
            'max' => 4,
        ])

    </a17-fieldset>

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

    @include('admin.partials.related')

@endsection
