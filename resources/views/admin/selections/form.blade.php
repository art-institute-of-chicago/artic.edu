@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'title',
        'label' => 'Title',
        'required' => true
    ])

    @formField('input', [
        'name' => 'short_copy',
        'label' => 'Short Intro copy',
    ])

    @formField('medias', [
        'name' => 'hero',
        'label' => 'Hero Image',
        'max' => 2,
    ])

    @formField('browser', [
        'routePrefix' => 'whatson',
        'name' => 'artworks',
        'moduleName' => 'artworks',
        'label' => 'Artworks',
        'max' => 500
    ])

     @formField('browser', [
        'routePrefix' => 'whatson',
        'name' => 'selections',
        'moduleName' => 'selections',
        'label' => 'Selections',
        'max' => 20
    ])

    @formField('browser', [
        'routePrefix' => 'whatson',
        'moduleName' => 'articles',
        'name' => 'articles',
        'label' => 'Article'
    ])
@stop
