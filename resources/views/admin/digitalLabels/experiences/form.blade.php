@php
    $ipad_url = $baseUrl . $item->slug . '/ipad';
@endphp

@extends('twill::layouts.form')

@section('contentFields')
    <br/><strong><a href="{{ url('collection/experiences/' . $item->id . '/slides') }}">{{ $item->slides->count() }} Slides</a></strong></br>
    <br/><h1><strong>iPad URL:</strong> <a href={{ $ipad_url }}>{{ $ipad_url }}</a></h1>
    <br/><h1><strong>Bundle ID: </strong>{{ $item->id }}</h1>
    @formField('checkbox', [
        'name' => 'archived',
        'label' => 'Archived'
    ])
@stop

@section('fieldsets')
<a17-fieldset title="Attract" id="attract" :open="true">
    @formField('input', [
        'name' => 'attract_title',
        'label' => 'Title'
    ])

    @formField('input', [
        'name' => 'attract_subhead',
        'label' => 'Subhead'
    ])
    
    @formField('repeater', ['type' => 'attract_experience_image'])

</a17-fieldset>

<a17-fieldset title="End" id="end" :open="true">
    @formField('input', [
        'name' => 'end_headline',
        'label' => 'Headline'
    ])

    @formField('input', [
        'name' => 'end_copy',
        'label' => 'Copy',
        'placeholder' => 'The End',
    ])

    @formField('repeater', ['type' => 'end_bg_experience_image'])

    <br />

    <a17-fieldset title="Credit" id="end" :open="true">
        @formField('input', [
            'name' => 'end_credit_subhead',
            'label' => 'Subhead'
        ])

        @formField('input', [
            'name' => 'end_credit_copy',
            'label' => 'Copy'
        ])

        @formField('repeater', ['type' => 'end_experience_image'])
    </a17-fieldset>

</a17-fieldset>
@stop