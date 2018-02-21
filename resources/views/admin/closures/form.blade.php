@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('select', [
        'name' => 'type',
        'label' => 'Type',
        'options' => $typeList,
        'placeholder' => 'Select a type',
    ])

    @formField('date_picker', [
        'name' => 'date_start',
        'label' => 'Start Date',
        'withTime' => false,
        'required' => true
    ])

    @formField('date_picker', [
        'name' => 'date_end',
        'label' => 'End Date',
        'withTime' => false,
        'required' => true
    ])

    @formField('input', [
        'name' => 'closure_copy',
        'label' => 'Closure Copy',
    ])
@stop
