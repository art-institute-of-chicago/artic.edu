@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('date_picker', [
        'name' => 'date',
        'label' => 'Publishing date',
    ])

    @formField('multi_select', [
        'name' => 'site_tags',
        'label' => 'Tags',
        'options' => $siteTagsList,
        'placeholder' => 'Select some tags',
    ])

    @formField('input', [
        'name' => 'title',
        'label' => 'Title',
    ])
    @formField('textarea', [
        'name' => 'copy',
        'label' => 'Short Copy'
    ])
    @formField('medias', [
        'media_role' => 'hero',
        'media_role_name' => 'Hero',
        'with_multiple' => false,
        'no_crop' => false
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
        'relationship' => 'artists',
        'module_name' => 'artists',
        'relationship_name' => 'related artists',
        'custom_title_prefix' => 'Add',
        'with_multiple' => true,
        'with_sort' => true,
        'hint' => 'Select related artists',
        'max' => 20
    ])

    @formField('browser', [
        'routePrefix' => 'whatson',
        'relationship' => 'selections',
        'module_name' => 'selections',
        'relationship_name' => 'related selections',
        'custom_title_prefix' => 'Add',
        'with_multiple' => true,
        'with_sort' => true,
        'hint' => 'Select related selections',
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
