@extends('twill::layouts.form', [
    'additionalFieldsets' => [
        ['fieldset' => 'content', 'label' => 'Content'],
    ]
])

@section('contentFields')
    <x-twill::input
        name='title_display'
        label='Title formatting (optional)'
        note='Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
    />

    <x-twill::files
        name='vtour_xml_file'
        label='Virtual tour XML file'
        note='Upload a .xml file'
    />

    <x-twill::medias
        label='Hero Image'
        name='hero'
        note='Minimum image width 3000px'
    />

    <x-twill::date-picker
        name='date'
        label='Display date'
        note='When was this virtual tour published?'
    />

    <x-twill::wysiwyg
        name='list_description'
        label='List description'
        note='Max 255 characters. Will be used in "Related Virtual Tours" and social media.'
        :maxlength='255'
        :toolbar-options="[ 'italic' ]"
    />

    <x-twill::input
        name='heading'
        label='Heading'
        type='textarea'
        :rows='3'
    />

    @formField('block_editor', [
        'blocks' => BlockHelpers::getBlocksForEditor([
            'paragraph', 'hr', 'artwork', 'split_block', 'quote', 'tour_stop', 'list', 'button', 'audio_player', 'membership_banner', 'mobile_app', 'artworks'
        ])
    ])
@stop
