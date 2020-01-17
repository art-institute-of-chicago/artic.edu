@extends('twill::layouts.form')

@section('contentFields')
    <br /><strong><a href="{{ url('/collection/articles_publications/issues/' . $item->id . '/articles') }}">{{ $item->articles->count() }} Articles</a></strong>
    @formField('input', [
        'name' => 'title_display',
        'label' => 'Title formatting (optional)',
        'note' => 'Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
    ])

    @formField('input', [
        'name' => 'issue_number',
        'label' => 'Issue number',
        'type' => 'number',
        'maxlength' => 3,
        'optional' => false,
        'note' => 'Required',
    ])

    @formField('date_picker', [
        'name' => 'date',
        'label' => 'Display date',
        'optional' => false,
        'withTime' => false,
        'note' => 'Required',
    ])

    @formField('wysiwyg', [
        'name' => 'description',
        'label' => 'Description',
        'toolbarOptions' => [
            'italic'
        ],
    ])

    @formField('wysiwyg', [
        'name' => 'list_description',
        'label' => 'List Description',
        'maxlength' => 255,
        'note' => 'Max 255 characters. Will be used on the issue landing and listing pages, and social media.',
        'toolbarOptions' => [
            'italic'
        ],
    ])

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Hero image',
        'name' => 'hero',
        'note' => 'Minimum image width 3000px'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'License image',
        'name' => 'license',
    ])

    @formField('input', [
        'name' => 'license_text',
        'label' => 'License text',
    ])
@stop
