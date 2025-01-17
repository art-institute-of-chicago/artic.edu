@extends('twill::layouts.form')

@section('contentFields')
    <x-twill::input
        name='destination'
        label='Destination'
        :required='true'
    />
@stop
