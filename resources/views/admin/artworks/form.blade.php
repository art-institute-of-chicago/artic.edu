@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('browser', [
        'routePrefix' => 'collection.articles_publications',
        'moduleName' => 'videos',
        'max' => 1,
        'name' => 'videos',
        'label' => 'Related video'
    ])

    @formField('browser', [
        'routePrefix' => 'collection.articles_publications',
        'moduleName' => 'articles',
        'max' => 1,
        'name' => 'sidebarArticle',
        'label' => 'Related article',
    ])

    @formField('browser', [
        'routePrefix' => 'exhibitions_events',
        'max' => 1,
        'name' => 'sidebarExhibitions',
        'label' => 'Related Exhibition',
        'moduleName' => 'exhibitions',
    ])

    @formField('browser', [
        'routePrefix' => 'exhibitions_events',
        'moduleName' => 'events',
        'name' => 'sidebarEvent',
        'label' => 'Related event',
        'max' => 1
    ])
@stop
