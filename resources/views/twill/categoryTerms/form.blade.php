@extends('twill::layouts.form')

@section('contentFields')
    <x-twill::input
        name='datahub_id'
        label='Datahub ID'
        disabled='true'
    />
    <x-twill::input
        name='title'
        label='API Title'
        disabled='true'
    />

    <x-twill::input
        name='subtype'
        label='Sub Type'
        disabled='true'
    />

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Thumbnail Image',
        'name' => 'thumb',
        'note' => 'Minimum image width 1500px'
    ])
@stop
