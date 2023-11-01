@extends('twill::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'title',
        'label' => 'Title',
        'required' => true
    ])

    @formField('input', [
        'name' => 'tooltip',
        'label' => 'Tooltip'
    ])

    @formField('wysiwyg', [
        'name' => 'description',
        'label' => 'Description',
        'note' => 'Will display instead of price table',
        'toolbarOptions' => [
            'italic', 'link'
        ],
    ])

    @formField('input', [
        'name' => 'link_label',
        'label' => 'Link label',
    ])

    @formField('input', [
        'name' => 'link_url',
        'label' => 'Link URL',
    ])
@stop
