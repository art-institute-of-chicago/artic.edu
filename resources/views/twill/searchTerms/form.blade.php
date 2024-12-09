@extends('twill::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'name',
        'label' => 'Name',
    ])

    @formField('input', [
        'name' => 'direct_url',
        'label' => 'Direct URL',
        'required' => true,
        'note' => 'Where should this term take the user?',
    ])
@stop
