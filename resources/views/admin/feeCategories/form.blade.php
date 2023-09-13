@extends('twill::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'title',
        'label' => 'Title',
        'required' => true
    ])

    @formField('input', [
        'name' => 'tooltip',
        'label' => 'Tooltip',
        'required' => true
    ])

    @formField('wysiwyg', [
        'name' => 'description',
        'label' => 'Description',
        'note' => 'Will display instead of price table',
        'toolbarOptions' => [
            'italic', 'link'
        ],
    ])
@stop
