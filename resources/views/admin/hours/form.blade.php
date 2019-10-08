@extends('twill::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'title',
        'label' => 'Title',
    ])

    @formField('input', [
        'name' => 'url',
        'label' => 'URL',
    ])

    @formField('date_picker', [
        'name' => 'valid_from',
        'label' => 'Valid From',
    ])

    @formField('date_picker', [
        'name' => 'valid_through',
        'label' => 'Valid Through',
    ])
@stop
