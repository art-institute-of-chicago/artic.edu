@extends('twill::layouts.form')

@section('contentFields')

    @formField('wysiwyg', [
        'name' => 'list_description',
        'label' => 'List description',
        'maxlength' => 255,
        'note' => 'Max 255 characters. Will be used for social media.',
        'toolbarOptions' => [
            'italic'
        ],
    ])

    @include('admin.partials.hero')
@stop

@section('fieldsets')
    <a17-fieldset title="Items" id="items">
        @formField('repeater', [ 'type' => 'magazineItems' ])
    </a17-fieldset>
@stop
