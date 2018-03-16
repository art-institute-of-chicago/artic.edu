@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('browser', [
        'routePrefix' => 'collection.articles_publications',
        'moduleName' => 'articles',
        'name' => 'articles',
        'label' => 'Article'
    ])

    @formField('browser', [
        'routePrefix' => 'collection',
        'moduleName' => 'artworks',
        'name' => 'artworks',
        'label' => 'Artworks'
    ])

    @formField('browser', [
        'routePrefix' => 'collection',
        'moduleName' => 'selections',
        'name' => 'selections',
        'label' => 'Selections'
    ])
@stop
