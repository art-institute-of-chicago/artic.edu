@extends('cms-toolkit::layouts.form')

@section('contentFields')
    {{-- @formField('input', [
        'name' => 'title',
        'label' => 'Title',
    ]) --}}

    @formField('input', [
        'name' => 'intro',
        'label' => 'Intro',
        'type' => 'textarea'
    ])

    @formField('input', [
        'name' => 'datahub_id',
        'label' => 'Datahub ID',
        'disabled' => true
    ])
@stop
