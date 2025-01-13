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

    <p>For a 1 day closure, use the same start and end date.</p>

    @formField('wysiwyg', [
        'name' => 'closure_copy',
        'label' => 'Closure Copy',
        'toolbarOptions' => [
            'italic', 'link'
        ],
        'maxlength' => 255
    ])
@stop

@push('vuexStore')
    window['{{ config('twill.js_namespace') }}'].STORE.form.fields.push({
        name: 'cmsFormTitle',
        value: '{{ $item->presentAdmin()->presentType }} closure'
    })
@endpush
