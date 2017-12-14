@extends('cms-toolkit::layouts.resources.form')

@section('form')
    {{ Form::model($form_fields, $form_options) }}
    <section class="box">
        <header class="header_small">
            <h3><b>{{ $form_fields['title'] or 'New item' }}</b></h3>
        </header>
        @formField('input', [
            'field' => 'datahub_id',
            'field_name' => 'Datahub ID'
        ])
        @formField('input', [
            'field' => 'name',
            'field_name' => 'Name',
        ])
        @formField('textarea', [
            'field' => 'biography',
            'field_name' => 'Biography'
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
    </section>
@stop


