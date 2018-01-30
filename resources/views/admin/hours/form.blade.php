@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('checkbox', [
        'name' => 'closed',
        'label' => 'Closed (data below will be ignored)',
    ])

    @formField('date_picker', [
        'name' => 'opening_time',
        'label' => 'Opening Time',
    ])

    @formField('date_picker', [
        'name' => 'closing_time',
        'label' => 'Closing Time',
    ])
@stop
