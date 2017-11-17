@extends('cms-toolkit::layouts.resources.form')

@section('form')
    {{ Form::model($form_fields, $form_options) }}
    <section class="box">
        <header class="header_small">
            <h3><b>{{ $form_fields['name'] or 'New item' }}</b></h3>
        </header>
        @formField('input', [
            'field' => 'name',
            'field_name' => 'Name',
        ])

        @formField('multi_select', [
            'field' => 'selected_segments',
            'field_name' => 'Segments',
            'list' => $segmentsList,
            'placeholder' => 'Select some segments',
        ])

    </section>
@stop


