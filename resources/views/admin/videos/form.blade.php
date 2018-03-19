@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'video_url',
        'label' => 'Video URL'
    ])

    @formField('date_picker', [
        'name' => 'date',
        'label' => 'Display date',
    ])

    @formField('input', [
        'name' => 'heading',
        'label' => 'Copy',
        'rows' => 3,
        'type' => 'textarea'
    ])
@stop
