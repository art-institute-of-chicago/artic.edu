@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('medias', [
        'label' => 'Hero',
        'name' => 'hero'
    ])

    @formField('browser', [
        'routePrefix' => 'whatson',
        'moduleName' => 'articles',
        'name' => 'articles',
        'label' => 'Article'
    ])

    @formField('browser', [
        'routePrefix' => 'whatson',
        'moduleName' => 'events',
        'name' => 'events',
        'label' => 'Events'
    ])

    @formField('browser', [
        'routePrefix' => 'whatson',
        'moduleName' => 'exhibitions',
        'name' => 'exhibitions',
        'label' => 'Exhibitions'
    ])


{{--
    #2 Removed for now?
     @formField('browser', [
        'routePrefix' => 'whatson',
        'moduleName' => 'artworks',
        'name' => 'artworks',
        'label' => 'Artworks'
    ])
 --}}
@stop
