@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('select', [
        'name' => 'type',
        'label' => 'Type',
        'list' => $typeList,
        'placeholder' => 'Select a type',
    ])

    @formField('date_picker', [
        'name' => 'date_start',
        'label' => 'Start Date',
        'date_settings' => 'closures_date_settings',
        'required' => true
    ])

    @formField('date_picker', [
        'name' => 'date_end',
        'label' => 'End Date',
        'date_settings' => 'closures_date_settings',
        'required' => true
    ])

    @formField('input', [
        'name' => 'closure_copy',
        'label' => 'Closure Copy',
    ])

    <script>
        var closures_date_settings = {
            lang:'en',
            format: 'm/d/Y',
            datepicker: true,
            timepicker: false,
            dayOfWeekStart:1,
        }
    </script>
@stop
