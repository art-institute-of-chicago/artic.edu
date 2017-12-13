@extends('cms-toolkit::layouts.resources.form')

@section('form')
    {{ Form::model($form_fields, $form_options) }}
    @formField('publish_status')

    <section class="box">
        <header class="header_small">
            <h3><b>Selections</b></h3>
        </header>

        @formField('input', [
            'field' => 'title',
            'field_name' => 'Title',
            'required' => true
        ])

        @formField('input', [
            'field' => 'short_copy',
            'field_name' => 'Short Intro copy',
        ])

        @formField('medias', [
            'media_role' => 'hero',
            'media_role_name' => 'Hero',
            'with_multiple' => true,
            'no_crop' => false,
            'max' => 2
        ])
    </section>

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
