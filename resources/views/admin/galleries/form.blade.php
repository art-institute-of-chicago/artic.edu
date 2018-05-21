@extends('twill::layouts.form')

@section('contentFields')

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Hero Image',
        'name' => 'hero'
    ])

    @formField('input', [
        'name' => 'caption',
        'label' => 'Caption'
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
