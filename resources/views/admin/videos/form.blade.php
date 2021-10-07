@extends('twill::layouts.form', [
    'additionalFieldsets' => [
        ['fieldset' => 'content', 'label' => 'Content'],
        ['fieldset' => 'related_to', 'label' => 'Related'],
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
            'paragraph', 'quote',
            'list', 'artwork', 'artworks', 'hr', 'split_block',
            'membership_banner', 'audio_player', 'tour_stop', 'button', 'mobile_app'
        ])
    ])
@stop

@section('fieldsets')

    <a17-fieldset id="related_to" title="Related">

        <p>If this is left blank, we will show the four most recently published videos.</p>

        @formField('browser', [
            'routePrefix' => 'collection.articles_publications',
            'name' => 'related_videos',
            'moduleName' => 'videos',
            'label' => 'Related videos',
            'max' => 4,
        ])

    </a17-fieldset>

    @include('admin.partials.related')

@endsection
