@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'video_url',
        'label' => 'Video URL'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Hero Image',
        'name' => 'hero',
        'note' => 'Minimum image width 3000px'
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
