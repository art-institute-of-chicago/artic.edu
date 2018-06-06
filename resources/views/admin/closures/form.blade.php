@extends('twill::layouts.form', ['contentFieldsetLabel' => 'Edit closure'])

@section('contentFields')
    @formField('select', [
        'name' => "type",
        'label' => "Type",
        'options' => $typesList,
        'placeholder' => 'Select a type',
        'required' => true
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
        'maxlength' => 255
    ])
@stop

@push('vuexStore')
    window.STORE.form.fields.push({
        name: 'cmsFormTitle',
        value: '{{ $item->presentAdmin()->presentType }} closure'
    })
@endpush
