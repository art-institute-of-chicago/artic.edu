@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('block_editor')
    @formField('date_picker', [
        'name' => 'date',
        'label' => 'Publishing date',
    ])

    @formField('multi_select', [
        'name' => 'siteTags',
        'label' => 'Tags',
        'options' => $siteTagsList,
        'placeholder' => 'Select some tags',
    ])

    @formField('input', [
        'name' => 'title',
        'label' => 'Title',
    ])
    @formField('input', [
        'name' => 'copy',
        'label' => 'Short Copy',
        'rows' => 3,
        'type' => 'textarea'
    ])

    @formField('medias', [
        'media_role' => 'hero',
        'media_role_name' => 'Hero',
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Hero Image',
        'name' => 'Hero Image'
    ])

    @formField('browser', [
        'routePrefix' => 'whatson',
        'name' => 'exhibitions',
        'moduleName' => 'exhibitions',
        'max' => 20,
        'label' => 'Related Exhibitions',
    ])

    @formField('browser', [
        'routePrefix' => 'whatson',
        'name' => 'articles',
        'moduleName' => 'articles',
        'max' => 20,
        'label' => 'Related Articles',
    ])

    @formField('browser', [
        'routePrefix' => 'whatson',
        'name' => 'artists',
        'moduleName' => 'artists',
        'max' => 20,
        'label' => 'Related Artists',
    ])

    @formField('browser', [
        'routePrefix' => 'whatson',
        'name' => 'selections',
        'moduleName' => 'selections',
        'max' => 20,
        'label' => 'Related Selections',
    ])

@stop
