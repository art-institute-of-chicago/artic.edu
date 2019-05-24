@extends('twill::layouts.form')

<p>The vanity path must be defined in lowercase. Once defined, they are case insensitive during use.</p>

@section('contentFields')
    @formField('input', [
        'name' => 'destination',
        'label' => 'Destination',
        'required' => true,
    ])
@stop
