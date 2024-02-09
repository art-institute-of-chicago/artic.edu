<link href="{{FrontendHelpers::revAsset('styles/app.css')}}" rel="stylesheet" />
<link href="{{FrontendHelpers::revAsset('styles/custom-tours-pdf.css')}}" rel="stylesheet" />

@extends('layouts.block')

@section('content')

<table border="1">
    <thead>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="thin"></td>
            <td class="crease"></td>
            <td class="thin"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="3">
                @if(isset($custom_tour['artworks'][5]))
                    <div class="artwork-image-container">
                        <img src="https://www.artic.edu/iiif/2/{{ $custom_tour['artworks'][5]['image_id'] }}/full/684,/0/default.jpg"/>
                    </div>
                @endif
            </td>
            <td colspan="3">
                @if(isset($custom_tour['artworks'][5]))
                    <p><span class="f-subheading-3">{{ $custom_tour['artworks'][5]['title'] }}</span></p>
                    @isset($custom_tour['artworks'][5]['gallery_title'])
                        <p><span class="f-body">{{ $custom_tour['artworks'][5]['gallery_title'] }}</span></p>
                    @endisset
                    @isset($custom_tour['artworks'][5]['description'])
                        <span class="f-body">{{ $custom_tour['artworks'][5]['description'] }}</span>
                    @endisset
                @endif
            </td>
            <td class="crease"></td>
            <td colspan="6">
                <div class="heading-image-container">
                    <img src="https://artic-web-test.imgix.net/a9a0fefa-2101-456b-9afa-cc34dccaf06d/unnamed1.jpg?rect=0%2C65%2C1391%2C783&auto=format%2Ccompress&q=80&fit=crop&crop=faces%2Ccenter&w=1000&h=563"/>
                </div>
            </td>
        </tr>

        <tr>
            <td colspan="6">
                @isset($custom_tour['artworks'][5]['objectNote'])
                    <span class="f-quote">"{{ $custom_tour['artworks'][5]['objectNote'] }}"</span>
                @endisset
            </td>
            <td class="crease"></td>
            <td colspan="6">
                <span class="title f-headline-editorial home-callout-text"><p>{{ $custom_tour['title'] }}</p></span>
            </td>
        </tr>

        <tr>
            <td colspan="3" rowspan="2">
                @if(isset($custom_tour['artworks'][6]))
                    <div class="artwork-image-container">
                        <img src="https://www.artic.edu/iiif/2/{{ $custom_tour['artworks'][6]['image_id'] }}/full/684,/0/default.jpg"/>
                    </div>
                @endif
            </td>
            <td colspan="3" rowspan="2">
                @if(isset($custom_tour['artworks'][6]))
                    <p><span class="f-subheading-3">{{ $custom_tour['artworks'][6]['title'] }}</span></p>
                    @isset($custom_tour['artworks'][6]['gallery_title'])
                        <p><span class="f-body">{{ $custom_tour['artworks'][6]['gallery_title'] }}</span></p>
                    @endisset
                    @isset($custom_tour['artworks'][6]['description'])
                        <span class="f-body">{{ $custom_tour['artworks'][6]['description'] }}</span>
                    @endisset
                @endif
            </td>
            <td class="crease" rowspan="2"></td>
            <td colspan="5">
                <span class="f-body">Tour made by</span>
            </td>
            <td colspan="1">
                <span class="f-body">{{ count($custom_tour['artworks']) }} artworks</strong><br/><em>from</em> <strong>{{ $unique_artists_count }} artists</strong></br><em>across</em> <strong>{{ $unique_galleries_count }} galleries</span>
            </td>
        </tr>

        <tr>
            <td colspan="6">
                <span class="f-quote">{{ $custom_tour['description'] }}</span>
            </td>
        </tr>

        <tr>
            <td colspan="6">
                @isset($custom_tour['artworks'][6]['objectNote'])
                    <span class="f-quote">"{{ $custom_tour['artworks'][6]['objectNote'] }}"</span>
                @endisset
            </td>
            <td class="crease"></td>
            <td colspan="2">
                <svg aria-hidden="true">
                    <use xlink:href="#icon--logo--outline--80" />
                    <use xlink:href="#icon--logo--outline--88" />
                    <use xlink:href="#icon--logo--outline--92" />
                </svg>
            </td>
        </tr>
    </tbody>
</table>

<table class="on-new-page">
    <tbody>
        <tr>
            <td colspan="3">
                @if(isset($custom_tour['artworks'][1]))
                    <div class="artwork-image-container">
                        <img src="https://www.artic.edu/iiif/2/{{ $custom_tour['artworks'][1]['image_id'] }}/full/684,/0/default.jpg"/>
                    </div>
                @endif
            </td>
            <td colspan="3">
                @if(isset($custom_tour['artworks'][1]))
                    <p><span class="f-subheading-3">{{ $custom_tour['artworks'][1]['title'] }}</span></p>
                    @isset($custom_tour['artworks'][1]['gallery_title'])
                        <p><span class="f-body">{{ $custom_tour['artworks'][1]['gallery_title'] }}</span></p>
                    @endisset
                    @isset($custom_tour['artworks'][1]['description'])
                        <span class="f-body">{{ $custom_tour['artworks'][1]['description'] }}</span>
                    @endisset
                @endif
            </td>
            <td class="crease"></td>
            <td colspan="3">
                @if(isset($custom_tour['artworks'][3]))
                    <div class="artwork-image-container">
                        <img src="https://www.artic.edu/iiif/2/{{ $custom_tour['artworks'][3]['image_id'] }}/full/684,/0/default.jpg"/>
                    </div>
                @endif
            </td>
            <td colspan="3">
                @if(isset($custom_tour['artworks'][3]))
                    <p><span class="f-subheading-3">{{ $custom_tour['artworks'][3]['title'] }}</span></p>
                    @isset($custom_tour['artworks'][3]['gallery_title'])
                        <p><span class="f-body">{{ $custom_tour['artworks'][3]['gallery_title'] }}</span></p>
                    @endisset
                    @isset($custom_tour['artworks'][3]['description'])
                        <span class="f-body">{{ $custom_tour['artworks'][3]['description'] }}</span>
                    @endisset
                @endif
            </td>
        </tr>

        <tr>
            <td colspan="6">
                @isset($custom_tour['artworks'][1]['objectNote'])
                    <span class="f-quote">"{{ $custom_tour['artworks'][1]['objectNote'] }}"</span>
                @endisset
            </td>
            <td class="crease"></td>
            <td colspan="6">
                @isset($custom_tour['artworks'][3]['objectNote'])
                    <span class="f-quote">"{{ $custom_tour['artworks'][3]['objectNote'] }}"</span>
                @endisset
            </td>
        </tr>

        <tr>
            <td colspan="3">
                @if(isset($custom_tour['artworks'][2]))
                    <div class="artwork-image-container">
                        <img src="https://www.artic.edu/iiif/2/{{ $custom_tour['artworks'][2]['image_id'] }}/full/684,/0/default.jpg"/>
                    </div>
                @endif
            </td>
            <td colspan="3">
                @if(isset($custom_tour['artworks'][2]))
                    <p><span class="f-subheading-3">{{ $custom_tour['artworks'][2]['title'] }}</span></p>
                    @isset($custom_tour['artworks'][2]['gallery_title'])
                        <p><span class="f-body">{{ $custom_tour['artworks'][2]['gallery_title'] }}</span></p>
                    @endisset
                    @isset($custom_tour['artworks'][2]['description'])
                        <span class="f-body">{{ $custom_tour['artworks'][2]['description'] }}</span>
                    @endisset
                @endif
            </td>
            <td class="crease"></td>
            <td colspan="3">
                @if(isset($custom_tour['artworks'][4]))
                    <div class="artwork-image-container">
                        <img src="https://www.artic.edu/iiif/2/{{ $custom_tour['artworks'][4]['image_id'] }}/full/684,/0/default.jpg"/>
                    </div>
                @endif
            </td>
            <td colspan="3">
                @if(isset($custom_tour['artworks'][4]))
                    <p><span class="f-subheading-3">{{ $custom_tour['artworks'][4]['title'] }}</span></p>
                    @isset($custom_tour['artworks'][4]['gallery_title'])
                        <p><span class="f-body">{{ $custom_tour['artworks'][4]['gallery_title'] }}</span></p>
                    @endisset
                    @isset($custom_tour['artworks'][4]['description'])
                        <span class="f-body">{{ $custom_tour['artworks'][4]['description'] }}</span>
                    @endisset
                @endif
            </td>
        </tr>

        <tr>
            <td colspan="6">
                @isset($custom_tour['artworks'][2]['objectNote'])
                    <span class="f-quote">"{{ $custom_tour['artworks'][2]['objectNote'] }}"</span>
                @endisset
            </td>
            <td class="crease"></td>
            <td colspan="6">
                @isset($custom_tour['artworks'][4]['objectNote'])
                    <span class="f-quote">"{{ $custom_tour['artworks'][4]['objectNote'] }}"</span>
                @endisset
            </td>
        </tr>
    </tbody>
</table>

@endsection
