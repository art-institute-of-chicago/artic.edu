@extends('cms-toolkit::layouts.resources.form')

@section('form')
    {{ Form::model($form_fields, $form_options) }}

    <section class="box">
        <header class="header_small">
            <h3><b>{{$item->present()->presentType}} - {{$item->present()->dayOfWeek}}</b></h3>
        </header>

        @formField('date_picker', [
            'field' => 'opening_time',
            'field_name' => 'Opening Time',
        ])

        @formField('date_picker', [
            'field' => 'closing_time',
            'field_name' => 'Closing Time',
        ])
    </section>

@stop
