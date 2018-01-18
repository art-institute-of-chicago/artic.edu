@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'datahub_id',
        'label' => 'Datahub ID'
    ])
    @formField('input', [
        'name' => 'name',
        'label' => 'Name',
    ])
    @formField('input', [
        'name' => 'biography',
        'label' => 'Biography',
        'type' => 'textarea'
    ])
@stop
