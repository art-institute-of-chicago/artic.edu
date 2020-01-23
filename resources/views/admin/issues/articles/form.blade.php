@extends('twill::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'title_display',
        'label' => 'Title formatting (optional)',
        'note' => 'Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
    ])

    @formField('input', [
        'name' => 'short_title_display',
        'label' => 'Short title',
        'note' => 'Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
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

    @formField('input', [
        'name' => 'type',
        'label' => 'Type',
    ])

    @formField('input', [
        'name' => 'abstract',
        'label' => 'Abstract',
        'type' => 'textarea',
    ])

    @formField('input', [
        'name' => 'author_display',
        'label' => 'Author display',
    ])

    @formField('browser', [
        'routePrefix' => 'collection',
        'moduleName' => 'authors',
        'name' => 'authors',
        'label' => 'Authors',
        'max' => 10
    ])

    @formField('input', [
        'name' => 'review_status',
        'label' => 'Review status',
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
