@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'name',
        'label' => 'Name',
    ])
@stop
