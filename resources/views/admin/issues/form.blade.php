@extends('twill::layouts.form')

@section('contentFields')
    <br /><strong><a href="{{ url('/collection/issues/' . $item->id . '/articles') }}">{{ $item->articles->count() }} Articles</a></strong>
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
        'name' => 'header_text',
        'label' => 'Header text',
        'toolbarOptions' => [
            'italic'
        ],
    ])

    @formField('wysiwyg', [
        'name' => 'list_description',
        'label' => 'List description',
        'maxlength' => 255,
        'note' => 'Max 255 characters. Will be used when the issue appears in listings and for social media.',
        'toolbarOptions' => [
            'italic'
        ],
    ])

    @include('admin.partials.hero')

    <hr>

    @formField('wysiwyg', [
        'name' => 'welcome_note_display',
        'label' => 'Welcome note text',
        'toolbarOptions' => [
            'italic'
        ],
    ])

    @formField('browser', [
        'name' => 'welcome_note_article',
        'label' => 'Welcome note article',
        'endpoint' => route('admin.collection.issues.articles.subbrowser',[
            'issue' => $item->id,
        ]),
        'max' => 1,
    ])

    <hr>

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

    <hr>

    @formField('wysiwyg', [
        'name' => 'cite_as',
        'label' => 'How to Cite',
        'toolbarOptions' => [
            'italic'
        ],
    ])
@stop

@section('fieldsets')

    @include('admin.partials.meta')

@stop
