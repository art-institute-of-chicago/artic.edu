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