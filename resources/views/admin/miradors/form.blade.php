@php

$views = [];

foreach (\App\Models\Mirador::$viewTypes as $key => $viewType) {
    array_push($views, [
        'value'  => $key,
        'label' => $viewType,
    ]);
}

@endphp

@extends('twill::layouts.form', [
    'additionalFieldsets' => [
        ['fieldset' => 'content', 'label' => 'Content'],
    ]
])

@section('contentFields')
    @formField('date_picker', [
        'name' => 'date',
        'label' => 'Display date',
        'note' => 'When was this mirador published?',
    ])

    @formField('input', [
        'type' => 'number',
        'name' => 'object_id',
        'label' => 'Object ID',
        'note' => 'Enter object ID to obtain manifest dynamically.'
    ])

    @formField('files', [
        'name' => 'upload_manifest_file',
        'label' => 'Alternative manifest file',
        'note' => 'Upload a .json file'
    ])

    @formField('radios', [
        'name' => 'default_view',
        'label' => 'Default View',
        'default' => 'single',
        'inline' => true,
        'options' => $views
    ])

@stop
