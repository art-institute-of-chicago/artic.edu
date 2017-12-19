@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'name',
        'label' => 'Name',
    ])

    @formField('multi_select', [
        'name' => 'selected_segments',
        'label' => 'Segments',
        'options' => $segmentsList,
        'placeholder' => 'Select some segments',
    ])
@stop
