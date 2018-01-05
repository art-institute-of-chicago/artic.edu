@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'header_copy',
        'label' => 'Header',
    ])
    @formField('input', [
        'name' => 'short_copy',
        'label' => 'Short Copy',
        'type' => 'textarea'
    ])
    @formField('medias', [
        'name' => 'hero',
        'label' => 'Hero',
    ])
    @formField('block_editor')
@stop

@section('fieldsets')
    <a17-fieldset id="attributes" title="Attributes">
        @formField('date_picker', [
             'name' => 'start_date',
             'label' => 'Start date',
        ])

        @formField('date_picker', [
             'name' => 'end_date',
             'label' => 'End date',
        ])

        @formField('input', [
            'name' => 'datahub_id',
            'label' => 'Datahub ID',
        ])

        @formField('multi_select', [
            'name' => 'site_tags',
            'label' => 'Tags',
            'options' => $siteTagsList,
            'placeholder' => 'Select some tags',
        ])
    </a17-fieldset>
    <a17-fieldset id="related" title="Related">
        @formField('browser', [
            'routePrefix' => 'whatson',
            'moduleName' => 'events',
            'name' => 'events',
            'label' => 'Related events',
            'note' => 'Select related events',
            'max' => 20
        ])

        @formField('browser', [
            'routePrefix' => 'whatson',
            'moduleName' => 'shopItems',
            'name' => 'shopItems',
            'label' => 'Related Shop Items',
            'note' => 'Select related Shop Items',
            'max' => 20
        ])

        @formField('browser', [
            'routePrefix' => 'general',
            'moduleName' => 'sponsors',
            'name' => 'sponsors',
            'label' => 'Sponsors',
            'note' => 'Select Sponsors',
            'max' => 20
        ])
    </a17-fieldset>
@stop
