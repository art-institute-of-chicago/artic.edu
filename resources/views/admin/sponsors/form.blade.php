@extends('cms-toolkit::layouts.resources.form')

@section('form')
    {{ Form::model($form_fields, $form_options) }}
    @formField('publish_status')

    <section class="box">
        <header class="header_small">
            <h3><b>Closure</b></h3>
        </header>

        @formField('input', [
            'field' => 'title',
            'field_name' => 'Title',
            'required' => true
        ])

        @formField('input', [
            'field' => 'copy',
            'field_name' => 'Sponsor Copy',
        ])
    </section>
@stop
