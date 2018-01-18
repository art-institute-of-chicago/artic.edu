@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'header_copy',
        'label' => 'Header',
    ])

    @formField('block_editor')
@stop

@section('fieldsets')
    <a17-fieldset id="attributes" title="Attributes">
        @formField('input', [
            'name' => 'datahub_id',
            'label' => 'Datahub ID',
            'disabled' => true
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
            'with_multiple' => true,
            'max' => 5,
            'name' => 'exhibitions',
            'label' => 'Related Exhibitions'
        ])

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
