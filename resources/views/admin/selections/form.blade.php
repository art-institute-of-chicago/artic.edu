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

    </section>
@stop
