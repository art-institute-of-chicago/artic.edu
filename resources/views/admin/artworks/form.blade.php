@extends('twill::layouts.form')

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


@section('fieldsets')
    <a17-fieldset id="metadata" title="Overwrite default metadata (optional)">
        @formField('input', [
            'name' => 'meta_title',
            'label' => 'Metadata Title'
        ])

        @formField('input', [
            'name' => 'meta_description',
            'label' => 'Metadata Description',
            'type' => 'textarea'
        ])
    </a17-fieldset>

    <a17-fieldset id="api" title="Datahub fields">
        @formField('input', [
            'name' => 'datahub_id',
            'label' => 'Datahub ID',
            'disabled' => true
        ])
    </a17-fieldset>
@stop
