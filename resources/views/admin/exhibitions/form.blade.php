@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('date_picker', [
         'name' => 'start_date',
         'label' => 'Start date',
    ])
    @formField('date_picker', [
         'name' => 'end_date',
         'label' => 'End date',
    ])

    @formField('input', [
        'name' => 'datahub_id',
        'label' => 'Datahub ID',
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
    @formField('input', [
        'name' => 'header_copy',
        'label' => 'Header'
    ])
    @formField('textarea', [
        'name' => 'short_copy',
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
        'relationship' => 'events',
        'module_name' => 'events',
        'relationship_name' => 'related events',
        'custom_title_prefix' => 'Add',
        'with_multiple' => true,
        'with_sort' => true,
        'hint' => 'Select related events',
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

    @formField('browser', [
        'routePrefix' => 'general',
        'relationship' => 'sponsors',
        'module_name' => 'sponsors',
        'relationship_name' => 'Sponsors',
        'custom_title_prefix' => 'Add',
        'with_multiple' => true,
        'with_sort' => true,
        'hint' => 'Select Sponsors',
        'max' => 20
    ])
@stop
