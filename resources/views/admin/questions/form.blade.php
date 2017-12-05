@extends('cms-toolkit::layouts.resources.form')

@section('form')
    {{ Form::model($form_fields, $form_options) }}
    @formField('publish_status')
    <section class="box">
        <header class="header_small">
            <h3><b>{{ $form_fields['title'] or 'New item' }}</b></h3>
        </header>
        @formField('textarea', [
            'field' => 'question',
            'field_name' => 'Question'
        ])
        @formField('textarea', [
            'field' => 'answer',
            'field_name' => 'Answer'
        ])
    </section>
@stop


