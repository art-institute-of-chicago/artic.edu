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
    <br/><strong><a href="{{ url('collection/interactive_features/experiences/' . $item->id . '/slides') }}">{{ $item->slides->count() }} Slides</a></strong><br/>
    <br/><h1><strong>Kiosk URL:</strong> <a href={{ $kiosk_url }}>{{ $kiosk_url }}</a></h1>
    <br/><h1><strong>Bundle ID: </strong>{{ $item->id }}</h1>

    @formField('select', [
        'name' => 'interactive_feature_id',
        'label' => 'Grouping',
        'placeholder' => 'Select an grouping',
        'options' => $groupingsList,
    ])

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

    @formField('wysiwyg', [
        'name' => 'listing_description',
        'label' => 'Listing Description',
        'type' => 'textarea',
        'maxlength' => 225,
        'note' => 'Used in listings and for social media',
        'toolbarOptions' => [
            'italic'
        ],
    ])

    @include('admin.partials.authors')

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

    @formField('checkbox', [
        'name' => 'is_unlisted',
        'label' => 'Don\'t show this experience in listings',
    ])

    @formField('checkbox', [
        'name' => 'is_in_magazine',
        'label' => 'Assume this experience is featured in a magazine issue',
    ])
@stop
