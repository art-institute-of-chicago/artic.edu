@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'question',
        'label' => 'Question',
        'type' => 'textarea'
    ])
    @formField('input', [
        'name' => 'answer',
        'label' => 'Answer',
        'type' => 'textarea'
    ])
@stop
