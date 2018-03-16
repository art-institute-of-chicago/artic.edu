@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('medias', [
        'label' => 'Hero',
        'name' => 'hero'
    ])

    @formField('browser', [
        'routePrefix' => 'collection.articles_publications',
        'moduleName' => 'articles',
        'name' => 'articles',
        'label' => 'Article'
    ])

    @formField('browser', [
        'routePrefix' => 'exhibitions_events',
        'moduleName' => 'events',
        'name' => 'events',
        'label' => 'Events'
    ])

    @formField('browser', [
        'routePrefix' => 'exhibitions_events',
        'moduleName' => 'exhibitions',
        'name' => 'exhibitions',
        'label' => 'Exhibitions'
    ])


{{--
    #2 Removed for now?
     @formField('browser', [
        'routePrefix' => 'collection',
        'moduleName' => 'artworks',
        'name' => 'artworks',
        'label' => 'Artworks'
    ])
 --}}
@stop
