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

<table border="1">
    <thead>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2">
                <svg aria-hidden="true">
                    <use xlink:href="#icon--logo--outline--80" />
                    <use xlink:href="#icon--logo--outline--88" />
                    <use xlink:href="#icon--logo--outline--92" />
                </svg>
            </td>
            <td colspan="10">
                <span class="title f-headline-editorial home-callout-text"><p>{{ $custom_tour['title'] }}</p></span>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <span class="f-body">{{ count($custom_tour['artworks']) }} artworks</strong><br/><em>from</em> <strong>{{ $unique_artists_count }} artists</strong></br><em>across</em> <strong>{{ $unique_galleries_count }} galleries</span>
            </td>
            <td colspan="3">
                <span class="f-body">Tour made by</span>
            </td>
            <td colspan="7">
                <span class="f-quote">{{ $custom_tour['description'] }}</span>
            </td>
        </tr>
    </tbody>
</table>

@foreach ($custom_tour['artworks'] as $artwork)
<table>
    <tbody>
        <tr class="artwork">
            <td colspan="5" rowspan="2">
                <div class="image-container">
                    <img src="https://www.artic.edu/iiif/2/{{ $artwork['image_id'] }}/full/!1087,700/0/default.jpg"/>
                </div>
            </td>
            <td colspan="3">
                <p><span class="f-subheading-3">{{ $artwork['title'] }}</span></p>
                @isset($artwork['gallery_title'])
                    <p><span class="f-body">{{ $artwork['gallery_title'] }}</span></p>
                @endisset
            </td>
            <td colspan="4">
                @isset($artwork['description'])
                    <span class="f-body">{{ $artwork['description'] }}</span>
                @endisset
            </td>
        </tr>

        <tr>
            <td colspan="7">
                @isset($artwork['objectNote'])
                    <span class="f-quote">"{{ $artwork['objectNote'] }}"</span>
                @endisset
            </td>
        </tr>
    </tbody>
</table>
@endforeach

@endsection
