@extends('twill::layouts.form', [
    'additionalFieldsets' => [
        ['fieldset' => 'side_related', 'label' => 'Sidebar Related'],
        ['fieldset' => 'metadata', 'label' => 'Metadata'],
        ['fieldset' => 'api', 'label' => 'Datahub fields'],
    ]
])

@section('contentFields')
    {{-- Nothing to see here yet. This section will always be shown --}}
    <p>Artwork content is defined in CITI.</p>
@stop

@section('fieldsets')
    @component('admin.partials.featured-related', ['form_fields' => $form_fields])
        @slot('articles', 'sidebarArticle')
        @slot('events', 'sidebarEvent')
        @slot('exhibitions', 'sidebarExhibitions')
        @slot('experiences', 'sidebarExperiences')
        @slot('videos', 'videos')
    @endcomponent

    @include('admin.partials.meta')

    <a17-fieldset id="api" title="Datahub fields">
        @formField('input', [
            'name' => 'datahub_id',
            'label' => 'Datahub ID',
            'disabled' => true
        ])
    </a17-fieldset>
@stop
