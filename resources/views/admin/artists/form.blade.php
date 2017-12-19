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
    @formField('textarea', [
        'name' => 'biography',
        'label' => 'Biography'
    ])

    @formField('browser', [
        'routePrefix' => 'whatson',
        'relationship' => 'shopItems',
        'module_name' => 'shopItems',
        'relationship_name' => 'Related Shop Items',
        'custom_title_prefix' => 'Add',
        'with_multiple' => true,
        'with_sort' => true,
        'hint' => 'Select related Shop Items',
        'max' => 20
    ])
@stop
