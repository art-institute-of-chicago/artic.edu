<link href="{{FrontendHelpers::revAsset('styles/app.css')}}" rel="stylesheet" />
<link href="{{FrontendHelpers::revAsset('styles/custom-tours-pdf.css')}}" rel="stylesheet" />

@extends('layouts.block')

@section('content')

{{-- 16% | 24% | 20% | 40% --}}
@php
    $col1 = 16;
    $col2 = 24;
    $col3 = 20;
    $col4 = 40;
@endphp

<table>
    <tr>
        <td style="width: {{ $col1 }}%">
            <svg aria-hidden="true">
                <use xlink:href="#icon--logo--outline--80" />
                <use xlink:href="#icon--logo--outline--88" />
                <use xlink:href="#icon--logo--outline--92" />
              </svg>
        </td>
        <td colspan="3">
            <span class="title f-headline-editorial home-callout-text"><p>{{ $custom_tour['title'] }}</p></span>
        </td>
    </tr>

    <tr>
        <td style="width: {{ $col1 }}%">
            <span class="f-body">{{ count($custom_tour['artworks']) }} artworks</strong><br/><em>from</em> <strong>{{ $unique_artists_count }} artists</strong></br><em>across</em> <strong>{{ $unique_galleries_count }} galleries</span>
        </td>
        <td style="width: {{ $col2 }}%">
            <span class="f-body">Tour made by</span>
        </td>
        <td colspan="2">
            <span class="f-quote">{{ $custom_tour['description'] }}</span>
        </td>
    </tr>

@foreach ($custom_tour['artworks'] as $artwork)
    <tr class="artwork">
        <td colspan="2" rowspan="2">
            <img src="https://www.artic.edu/iiif/2/{{ $artwork['image_id'] }}/full/!1087,700/0/default.jpg"/>
        </td>
        <td style="width: {{ $col3 }}%">
            <p><span class="f-headline-editorial">{{ $artwork['title'] }}</span></p>
            @isset($artwork['gallery_title'])
                <p><span class="f-body">{{ $artwork['gallery_title'] }}</span></p>
            @endisset
        </td>
        <td style="width: {{ $col4 }}%">
            @isset($artwork['description'])
                <span class="f-caption-title">{{ $artwork['description'] }}</span>
            @endisset
        </td>
    </tr>

    <tr>
        <td colspan="2">
            @isset($artwork['objectNote'])
                <span class="f-quote">"{{ $artwork['objectNote'] }}"</span>
            @endisset
        </td>
    </tr>
@endforeach
</table>

@endsection
