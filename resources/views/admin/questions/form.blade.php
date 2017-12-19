@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('textarea', [
        'name' => 'question',
        'label' => 'Question'
    ])
    @formField('textarea', [
        'name' => 'answer',
        'label' => 'Answer'
    ])
@stop
