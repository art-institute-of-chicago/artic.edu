@extends('twill::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'tour_id',
        'label' => 'Tour ID',
        'maxlength' => 25
    ])
@stop
