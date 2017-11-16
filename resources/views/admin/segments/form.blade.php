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
    </section>
@stop


