@extends('twill::layouts.form')

@section('contentFields')
    @formField('medias', [
        'name' => 'profile',
        'label' => 'Logo',
        'with_multiple' => false,
        'no_crop' => false
    ])
@stop
