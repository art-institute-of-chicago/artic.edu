@php
    $kiosk_domain = config('app.kiosk_domain');

    if (is_array($kiosk_domain)) {
        $kiosk_domain = $kiosk_domain[0] ?? config('app.url');
    }

    $kiosk_url = implode('', [
        request()->getScheme() . '://',
        $kiosk_domain,
        '/interactive-features',
        '/' . $item->slug
    ]);
@endphp

@extends('twill::layouts.form')

@section('contentFields')
    <br/><strong><a href="{{ url('collection/interactiveFeatures/experiences/' . $item->id . '/slides') }}">{{ $item->slides->count() }} Slides</a></strong><br/>
    <br/><h1><strong>Kiosk URL:</strong> <a href={{ $kiosk_url }}>{{ $kiosk_url }}</a></h1>
    <br/><h1><strong>Bundle ID: </strong>{{ $item->id }}</h1>

    <x-twill::select
        name='interactive_feature_id'
        label='Grouping'
        placeholder='Select an grouping'
        :options="$groupingsList"
    />

    @formField('medias', [
        'name' => 'thumbnail',
        'label' => 'Thumbnail',
        'max' => 1,
    ])

    <x-twill::input
        name='subtitle'
        label='Subtitle'
        :maxlength='300'
    />

    <x-twill::wysiwyg
        name='listing_description'
        label='Listing Description'
        type='textarea'
        note='Used in listings and for social media'
        :maxlength='225'
        :toolbar-options="[ 'italic' ]"
    />

    @include('twill.partials.authors')

    <x-twill::checkbox
        name='archived'
        label='Archived'
    />

    <x-twill::checkbox
        name='kiosk_only'
        label='Kiosk only'
    />

    <x-twill::checkbox
        name='is_unlisted'
        label="Don't show this experience in listings"
    />

    <x-twill::checkbox
        name='is_in_magazine'
        label='Assume this experience is featured in a magazine issue'
    />

    @formField('multi_select', [
        'name' => 'categories',
        'label' => 'Categories',
        'options' => $categoriesList,
        'placeholder' => 'Select some categories',
    ])
@stop
