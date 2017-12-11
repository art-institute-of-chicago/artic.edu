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
    </section>
@stop


