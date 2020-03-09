@php
    $kiosk_url = implode('', [
        request()->getScheme() . '://',
        config('app.kiosk_domain'),
        '/interactive-features',
        '/' . $item->slug
    ]);
@endphp

@extends('twill::layouts.form')

@section('contentFields')
    <br/><strong><a href="{{ url('collection/experiences/' . $item->id . '/slides') }}">{{ $item->slides->count() }} Slides</a></strong><br/>
    <br/><h1><strong>Kiosk URL:</strong> <a href={{ $kiosk_url }}>{{ $kiosk_url }}</a></h1>
    <br/><h1><strong>Bundle ID: </strong>{{ $item->id }}</h1>

    @formField('medias', [
        'name' => 'thumbnail',
        'label' => 'Thumbnail',
        'max' => 1,
    ])

    @formField('input', [
        'name' => 'subtitle',
        'label' => 'Subtitle',
        'maxlength' => 300
    ])

    @formField('input', [
        'name' => 'description',
        'label' => 'Description',
        'type' => 'textarea',
        'maxlength' => 300,
        'note' => 'Used in listings and for social media',
    ])

    @formField('checkbox', [
        'name' => 'archived',
        'label' => 'Archived'
    ])

    @formField('checkbox', [
        'name' => 'kiosk_only',
        'label' => 'Kiosk only',
    ])

    @formField('checkbox', [
        'name' => 'show_on_articles',
        'label' => 'Show on "Articles" listing',
    ])
@stop
