@extends('twill::layouts.form', [
    'additionalFieldsets' => [
        ['fieldset' => 'content', 'label' => 'Content'],
    ]
])

@section('contentFields')
    @formField('input', [
        'name' => 'title_display',
        'label' => 'Title formatting (optional)',
        'note' => 'Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
    ])

    @formField('files', [
        'name' => 'vtour_xml_file',
        'label' => 'Virtual tour XML file',
        'note' => 'Upload a .xml file'
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
        'note' => 'When was this virtual tour published?',
    ])

    @formField('wysiwyg', [
        'name' => 'list_description',
        'label' => 'List description',
        'maxlength' => 255,
        'note' => 'Max 255 characters. Will be used in "Related Virtual Tours" and social media.',
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
