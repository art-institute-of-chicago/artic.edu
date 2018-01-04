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
    @formField('browser', [
        'routePrefix' => 'whatson',
        'moduleName' => 'shopItems',
        'name' => 'shopItems',
        'label' => 'Related shop items',
        'max' => 20
    ])
@stop
