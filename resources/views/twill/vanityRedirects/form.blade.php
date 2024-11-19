@extends('twill::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'destination',
        'label' => 'Destination',
        'required' => true,
    ])
@stop
