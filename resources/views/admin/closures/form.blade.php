@extends('cms-toolkit::layouts.resources.form')

@section('form')
    {{ Form::model($form_fields, $form_options) }}
    @formField('publish_status')

    <section class="box">
        <header class="header_small">
            <h3><b>Closure</b></h3>
        </header>

        @formField('select', [
            'field' => 'type',
            'field_name' => 'Type',
            'list' => $typeList,
            'placeholder' => 'Select a type',
        ])

        @formField('input', [
            'field' => 'closure_copy',
            'field_name' => 'Closure Copy',
        ])

        @formField('date_picker', [
            'field' => 'date_start',
            'field_name' => 'Start Date',
        ])

        @formField('date_picker', [
            'field' => 'date_end',
            'field_name' => 'End Date',
        ])
    </section>

@stop
