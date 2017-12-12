@extends('cms-toolkit::layouts.resources.form')

@section('form')
    {{ Form::model($form_fields, $form_options) }}
    <section class="box">
        <header class="header_small">
            <h3><b>{{ $form_fields['title'] or 'New item' }}</b></h3>
        </header>
        @formField('input', [
            'field' => 'datahub_id',
            'field_name' => 'Datahub ID',
            'required' => true
        ])
        @formField('input', [
            'field' => 'title',
            'field_name' => 'Title',
            'required' => true
        ])
        @formField('multi_select', [
            'field' => 'site_tags',
            'field_name' => 'Tags',
            'list' => $siteTagsList,
            'placeholder' => 'Select some tags',
        ])
        @formField('input', [
            'field' => 'subtitle',
            'field_name' => 'Subtitle',
        ])
        @formField('textarea', [
            'field' => 'copy',
            'field_name' => 'Copy'
        ])
    </section>

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
@stop


