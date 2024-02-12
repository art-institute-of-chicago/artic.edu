@php
    use App\Helpers\StringHelpers;
@endphp
<link href="{{FrontendHelpers::revAsset('styles/app.css')}}" rel="stylesheet">
<link href="{{FrontendHelpers::revAsset('styles/custom-tours-pdf.css')}}" rel="stylesheet">

@extends('layouts.block')

@section('content')

<table>
    <thead>
        <tr>
            <td class="col1"></td>
            <td class="gutter"></td>
            <td class="col2"></td>
            <td class="crease"></td>
            <td class="col3"></td>
            <td class="gutter"></td>
            <td class="col4"></td>
            <td class="gutter"></td>
            <td class="col5"></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td rowspan="3">
                @if(isset($custom_tour['artworks'][4]))
                    <div class="artwork-image-container">
                        <img src="https://www.artic.edu/iiif/2/{{ $custom_tour['artworks'][4]['image_id'] }}/full/684,/0/default.jpg">
                    </div>
                @endif
            </td>
            <td class="gutter" rowspan="3"></td>
            <td class="tombstone">
                @if(isset($custom_tour['artworks'][4]))
                    <p><span class="f-headline-editorial t-artwork-title">{{ $custom_tour['artworks'][4]['title'] }}</span></p>
                    @isset($custom_tour['artworks'][4]['artist_title'])
                        <p><span class="f-body t-artist-title">{{ $custom_tour['artworks'][4]['artist_title'] }}</span></p>
                    @endisset
                    @isset($custom_tour['artworks'][4]['gallery_title'])
                        <p><span class="f-body t-artist-title">{{ $custom_tour['artworks'][4]['gallery_title'] }}</span></p>
                    @endisset
                @endif
            </td>
            <td class="crease" rowspan="12"></td>
            <td colspan="5" rowspan="3">
                <div class="heading-image-container">
                    <img src="https://artic-web-test.imgix.net/a9a0fefa-2101-456b-9afa-cc34dccaf06d/unnamed1.jpg?rect=0%2C65%2C1391%2C783&auto=format%2Ccompress&q=80&fit=crop&crop=faces%2Ccenter&w=1000&h=563">
                </div>
            </td>
        </tr>

        <tr>
            <td class="vertical-gutter-short"></td>
        </tr>

        <tr>
            <td class="short-description">
                @if(isset($custom_tour['artworks'][4]))
                    @isset($custom_tour['artworks'][4]['description'])
                        <span class="f-body t-short-description">{{ StringHelpers::truncateStr($custom_tour['artworks'][4]['description'], 452) }}</span>
                    @endisset
                @endif
            </td>
        </tr>

        <tr>
            <td colspan="3" class="vertical-gutter-tall"></td>
            <td colspan="5" class="vertical-gutter-tall"></td>
        </tr>

        <tr>
            <td colspan="3" class="c-object-note">
                @isset($custom_tour['artworks'][4]['objectNote'])
                    <span class="f-quote t-object-note">&#x201C;{{ $custom_tour['artworks'][4]['objectNote'] }}&#x201D;</span>
                @endisset
            </td>
            <td colspan="5" rowspan="2">
                <span class="f-headline-editorial t-home-callout-text">{{ $custom_tour['title'] }}</span>
            </td>
        </tr>

        <tr>
            <td colspan="3" class="vertical-gutter-tall"></td>
        </tr>

        <tr>
            <td rowspan="4">
                @if(isset($custom_tour['artworks'][5]))
                    <div class="artwork-image-container">
                        <img src="https://www.artic.edu/iiif/2/{{ $custom_tour['artworks'][5]['image_id'] }}/full/684,/0/default.jpg">
                    </div>
                @endif
            </td>
            <td class="gutter" rowspan="4"></td>
            <td class="tombstone" rowspan="2">
                @if(isset($custom_tour['artworks'][5]))
                    <p><span class="f-headline-editorial t-artwork-title">{{ $custom_tour['artworks'][5]['title'] }}</span></p>
                    @isset($custom_tour['artworks'][5]['artist_title'])
                        <p><span class="f-body t-artist-title">{{ $custom_tour['artworks'][5]['artist_title'] }}</span></p>
                    @endisset
                    @isset($custom_tour['artworks'][5]['gallery_title'])
                        <p><span class="f-body t-artist-title">{{ $custom_tour['artworks'][5]['gallery_title'] }}</span></p>
                    @endisset
                @endif
            </td>
            <td colspan="5" class="vertical-gutter-short"></td>
        </tr>

        <tr>
            <td colspan="3"><span class="f-headline t-made-by">{{ isset($custom_tour['creatorName']) ? 'Tour made by ' . $custom_tour['creatorName'] . (isset($custom_tour['recipientName']) ? ' for ' . $custom_tour['recipientName'] : '') : ''}}</span></td>
            <td class="gutter"></td>
            <td><span class="f-body t-sum">{{ count($custom_tour['artworks']) }} artworks<br><em>from</em> {{ $unique_artists_count }} artists<br><em>across</em> {{ $unique_galleries_count }} galleries</span></td>
        </tr>

        <tr>
            <td class="vertical-gutter-short"></td>
            <td colspan="5" class="vertical-gutter-short"></td>
        </tr>

        <tr>
            <td class="short-description">
                @if(isset($custom_tour['artworks'][5]))
                    @isset($custom_tour['artworks'][5]['description'])
                        <span class="f-body t-short-description">{{ StringHelpers::truncateStr($custom_tour['artworks'][5]['description'], 452) }}</span>
                    @endisset
                @endif
            </td>

            <td colspan="5">
                <span class="f-quote t-tour-description">{{ $custom_tour['description'] ?? null }}</span>
            </td>
        </tr>

        <tr>
            <td colspan="3" class="vertical-gutter-tall"></td>
            <td colspan="5" class="vertical-gutter-tall"></td>
        </tr>

        <tr>
            <td colspan="3" class="c-object-note">
                @isset($custom_tour['artworks'][5]['objectNote'])
                    <span class="f-quote t-object-note">&#x201C;{{ $custom_tour['artworks'][5]['objectNote'] }}&#x201D;</span>
                @endisset
            </td>
            <td colspan="5" class="logos">
                <img class="i-aic" src="/dist/images/my_museum_tour--aic.png"><img class="i-bloomberg" src="/dist/images/my_museum_tour--bloomberg.png">
            </td>
        </tr>
    </tbody>
</table>

@endsection
