@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'datahub_id',
        'label' => 'Datahub ID',
        'required' => true
    ])
    @formField('input', [
        'name' => 'title',
        'label' => 'Title',
        'required' => true
    ])
    @formField('multi_select', [
        'name' => 'site_tags',
        'label' => 'Tags',
        'optionq' => $siteTagsList,
        'placeholder' => 'Select some tags',
    ])
    @formField('input', [
        'name' => 'subtitle',
        'label' => 'Subtitle',
    ])
    @formField('textarea', [
        'name' => 'copy',
        'label' => 'Copy'
    ])

    @formField('browser', [
        'routePrefix' => 'whatson',
        'relationship' => 'selections',
        'module_name' => 'selections',
        'relationship_name' => 'related selections',
        'custom_title_prefix' => 'Add',
        'with_multiple' => true,
        'with_sort' => false,
        'hint' => 'Select related selections',
        'max' => 20
    ])

    @formField('browser', [
        'routePrefix' => 'whatson',
        'relationship' => 'exhibitions',
        'module_name' => 'exhibitions',
        'relationship_name' => 'related exhibitions',
        'custom_title_prefix' => 'Add',
        'with_multiple' => true,
        'with_sort' => true,
        'hint' => 'Select related exhibitions',
        'max' => 20
    ])

    @formField('browser', [
        'routePrefix' => 'whatson',
        'relationship' => 'articles',
        'module_name' => 'articles',
        'relationship_name' => 'related articles',
        'custom_title_prefix' => 'Add',
        'with_multiple' => true,
        'with_sort' => true,
        'hint' => 'Select related articles',
        'max' => 20
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
