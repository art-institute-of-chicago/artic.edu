@extends('twill::layouts.form')

@section('contentFields')
    @formField('medias', [
        'with_multiple' => false,
        'label' => 'Image',
        'name' => 'hero',
        'note' => 'Minimum image width 3000px'
    ])
@stop

@section('fieldsets')
    <a17-fieldset id="attributes" title="Attributes">
        @formField('input', [
            'name' => 'datahub_id',
            'label' => 'Datahub ID',
            'disabled' => true
        ])
    </a17-fieldset>
@stop