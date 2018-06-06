@extends('cms-toolkit::layouts.form')

@section('contentFields')

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Hero Image',
        'name' => 'hero',
        'note' => 'Minimum image width 2000px'
    ])

    @formField('input', [
        'name' => 'caption',
        'label' => 'Caption',
        'maxlength' => 255
    ])

    @formField('wysiwyg', [
        'name' => 'intro',
        'label' => 'Intro',
    ])

    @formField('input', [
        'name' => 'datahub_id',
        'label' => 'Datahub ID',
        'disabled' => true
    ])
@stop
