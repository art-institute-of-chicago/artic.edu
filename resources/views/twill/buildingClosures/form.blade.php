@extends('twill::layouts.form', ['contentFieldsetLabel' => 'Edit closure'])

@section('contentFields')
    <x-twill::select
        name='type'
        label='Type'
        placeholder='Select a type'
        :required='true'
        :options='$typesList'
    />

    <x-twill::date-picker
        name='date_start'
        label='Start Date'
        withTime='false'
        :required='true'
    />

    <x-twill::date-picker
        name='date_end'
        label='End Date'
        withTime='false'
        :required='true'
    />

    <p>For a 1 day closure, use the same start and end date.</p>

    <x-twill::wysiwyg
        name='closure_copy'
        label='Closure Copy'
        :maxlength="255"
        :toolbar-options="[ 'italic', 'link' ]"
    />
@stop

@push('vuexStore')
    window['{{ config('twill.js_namespace') }}'].STORE.form.fields.push({
        name: 'cmsFormTitle',
        value: '{{ $item->presentAdmin()->presentType }} closure'
    })
@endpush
