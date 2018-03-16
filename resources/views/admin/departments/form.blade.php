@extends('cms-toolkit::layouts.form')

@section('contentFields')

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Hero Image',
        'name' => 'hero'
    ])

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

    @formField('browser', [
        'routePrefix' => 'collection',
        'name' => 'artworks',
        'moduleName' => 'artworks',
        'label' => 'Artworks',
        'max' => 500
    ])
@stop
