@extends('twill::layouts.form')

@section('contentFields')
    <x-twill::input
        name='name'
        label='Name'
    />

    <x-twill::input
        name='direct_url'
        label='Direct URL'
        note='Where should this term take the user?'
        :required='true'
    />
@stop
