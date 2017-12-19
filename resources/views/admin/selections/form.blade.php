@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'title',
        'label' => 'Title',
        'required' => true
    ])

    @formField('input', [
        'name' => 'short_copy',
        'label' => 'Short Intro copy',
    ])

    @formField('medias', [
        'media_role' => 'hero',
        'media_role_name' => 'Hero',
        'with_multiple' => true,
        'no_crop' => false,
        'max' => 2
    ])

    @formField('browser', [
        'routePrefix' => 'whatson',
        'relationship' => 'artworks',
        'module_name' => 'artworks',
        'relationship_name' => 'related artworks',
        'custom_title_prefix' => 'Add',
        'with_multiple' => true,
        'with_sort' => true,
        'hint' => 'Select related artworks',
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
@stop
