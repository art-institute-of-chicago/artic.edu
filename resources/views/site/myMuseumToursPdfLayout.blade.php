@php
    use App\Helpers\StringHelpers;
@endphp
<link href="{{FrontendHelpers::revAsset('styles/app.css')}}" rel="stylesheet">
<link href="{{FrontendHelpers::revAsset('styles/my-museum-tour-pdf.css')}}" rel="stylesheet">

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
            <td class="col51"></td>
            <td class="col52"></td>
            <td class="col53"></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td rowspan="3">
                @php
                    $imageDims = '684,';
                    $class = '';
                @endphp
                @if(isset($my_museum_tour['artworks'][4]['thumbnail']['width']) && $my_museum_tour['artworks'][4]['thumbnail']['width'] > $my_museum_tour['artworks'][4]['thumbnail']['height'])
                    @php
                        $imageDims = ',684';
                        $class = 'landscape';
                    @endphp
                @endif
                @if(isset($my_museum_tour['artworks'][4]))
                    <div class="artwork-image-container">
                        <img class="{{ $class ?: '' }}" src="https://www.artic.edu/iiif/2/{{ $my_museum_tour['artworks'][4]['image_id'] }}/full/{{ $imageDims }}/0/default.jpg">
                    </div>
                @endif
            </td>
            <td class="gutter" rowspan="3"></td>
            <td class="tombstone">
                @if(isset($my_museum_tour['artworks'][4]))
                    <p><span class="f-headline-editorial t-artwork-title">{{ StringHelpers::truncateStr($my_museum_tour['artworks'][4]['title'], 65) }}</span></p>
                    @isset($my_museum_tour['artworks'][4]['artist_title'])
                        <p><span class="f-body t-artist-title">{{ $my_museum_tour['artworks'][4]['artist_title'] }}</span></p>
                    @endisset
                    @isset($my_museum_tour['artworks'][4]['gallery_title'])
                        <p><span class="f-body t-artist-title">{{ $my_museum_tour['artworks'][4]['gallery_title'] }}</span></p>
                    @endisset
                @endif
            </td>
            <td class="crease" rowspan="12"></td>
            <td colspan="7" rowspan="3">
                <div class="heading-image-container">
                    <img src="{{ $headerImage['src'] ?? 'https://artic-web.imgix.net/7a9ecbc2-7d8c-41e7-8649-650f1cc5c184/PDFheroimage.png?auto=format%2Ccompress&q=80&fit=crop&crop=faces%2Ccenter' }}&w=1000&h=563">
                </div>
            </td>
        </tr>

        <tr>
            <td class="vertical-gutter-short"></td>
        </tr>

        <tr>
            <td class="short-description">
                @if(isset($my_museum_tour['artworks'][4]))
                    @isset($my_museum_tour['artworks'][4]['description'])
                        <span class="f-body t-short-description">{{ StringHelpers::truncateStr($my_museum_tour['artworks'][4]['description'], 452) }}</span>
                    @endisset
                @endif
            </td>
        </tr>

        <tr>
            <td colspan="3" class="vertical-gutter-tall"></td>
            <td colspan="7" class="vertical-gutter-tall"></td>
        </tr>

        <tr>
            <td colspan="3" class="c-object-note">
                @isset($my_museum_tour['artworks'][4]['objectNote'])
                    <span class="f-quote t-object-note">&#x201C;{{ $my_museum_tour['artworks'][4]['objectNote'] }}&#x201D;</span>
                @endisset
            </td>
            <td colspan="7" rowspan="2">
                <span class="f-headline-editorial t-home-callout-text">{{ $my_museum_tour['title'] }}</span>
            </td>
        </tr>

        <tr>
            <td colspan="3" class="vertical-gutter-tall"><div class="artwork-divider"></div></td>
        </tr>

        <tr>
            <td rowspan="4">
                @php
                    $imageDims = '684,';
                    $class = '';
                @endphp
                @if(isset($my_museum_tour['artworks'][5]['thumbnail']['width']) && $my_museum_tour['artworks'][5]['thumbnail']['width'] > $my_museum_tour['artworks'][5]['thumbnail']['height'])
                    @php
                        $imageDims = ',684';
                        $class = 'landscape';
                    @endphp
                @endif
                @if(isset($my_museum_tour['artworks'][5]))
                    <div class="artwork-image-container">
                        <img class="{{ $class ?: '' }}" src="https://www.artic.edu/iiif/2/{{ $my_museum_tour['artworks'][5]['image_id'] }}/full/{{ $imageDims }}/0/default.jpg">
                    </div>
                @endif
            </td>
            <td class="gutter" rowspan="4"></td>
            <td class="tombstone" rowspan="2">
                @if(isset($my_museum_tour['artworks'][5]))
                    <p><span class="f-headline-editorial t-artwork-title">{{ StringHelpers::truncateStr($my_museum_tour['artworks'][5]['title'], 65) }}</span></p>
                    @isset($my_museum_tour['artworks'][5]['artist_title'])
                        <p><span class="f-body t-artist-title">{{ $my_museum_tour['artworks'][5]['artist_title'] }}</span></p>
                    @endisset
                    @isset($my_museum_tour['artworks'][5]['gallery_title'])
                        <p><span class="f-body t-artist-title">{{ $my_museum_tour['artworks'][5]['gallery_title'] }}</span></p>
                    @endisset
                @endif
            </td>
            <td colspan="7" class="vertical-gutter-short"></td>
        </tr>

        <tr>
            <td colspan="3"><span class="f-headline t-made-by">{{ isset($my_museum_tour['creatorName']) ? 'Tour made by ' . $my_museum_tour['creatorName'] . (isset($my_museum_tour['recipientName']) ? ' for ' . $my_museum_tour['recipientName'] : '') : ''}}</span></td>
            <td class="gutter"></td>
            <td colspan="3"><span class="f-body t-sum">{{ count($my_museum_tour['artworks']) }} artworks<br><em>from</em> {{ $unique_artists_count }} artists<br><em>across</em> {{ $unique_galleries_count }} galleries</span></td>
        </tr>

        <tr>
            <td class="vertical-gutter-short"></td>
            <td colspan="7" class="vertical-gutter-short"></td>
        </tr>

        <tr>
            <td class="short-description">
                @if(isset($my_museum_tour['artworks'][5]))
                    @isset($my_museum_tour['artworks'][5]['description'])
                        <span class="f-body t-short-description">{{ StringHelpers::truncateStr($my_museum_tour['artworks'][5]['description'], 452) }}</span>
                    @endisset
                @endif
            </td>

            <td colspan="7">
                <span class="f-quote t-tour-description">{{ $my_museum_tour['description'] ?? null }}</span>
            </td>
        </tr>

        <tr>
            <td colspan="3" class="vertical-gutter-tall"></td>
            <td colspan="7" class="vertical-gutter-tall"></td>
        </tr>

        <tr>
            <td colspan="3" class="c-object-note">
                @isset($my_museum_tour['artworks'][5]['objectNote'])
                    <span class="f-quote t-object-note">&#x201C;{{ $my_museum_tour['artworks'][5]['objectNote'] }}&#x201D;</span>
                @endisset
            </td>
            <td class="logos">
                <img class="i-aic-bloomberg" src="/dist/images/my_museum_tour--aic-bloomberg.png">
            </td>
            <td class="gutter"></td>
            <td colspan="3" class="logos">
            </td>
            <td colspan="2" class="logos">
                <p class="f-body t-qr-caption"><span>See your tour here</span></p>
                <img class="i-qrcode" src="{{ route('my-museum-tour.qrcode', [ 'id' => $id ], false); }}">
            </td>
        </tr>
    </tbody>
</table>

<table class="on-new-page">
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
            <td class="col51"></td>
            <td class="col52"></td>
            <td class="col53"></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td rowspan="3">
                @php
                    $imageDims = '684,';
                    $class = '';
                @endphp
                @if(isset($my_museum_tour['artworks'][0]['thumbnail']['width']) && $my_museum_tour['artworks'][0]['thumbnail']['width'] > $my_museum_tour['artworks'][0]['thumbnail']['height'])
                    @php
                        $imageDims = ',684';
                        $class = 'landscape';
                    @endphp
                @endif
                @if(isset($my_museum_tour['artworks'][0]))
                    <div class="artwork-image-container">
                        <img class="{{ $class ?: '' }}" src="https://www.artic.edu/iiif/2/{{ $my_museum_tour['artworks'][0]['image_id'] }}/full/{{ $imageDims }}/0/default.jpg">
                    </div>
                @endif
            </td>
            <td class="gutter" rowspan="3"></td>
            <td class="tombstone">
                @if(isset($my_museum_tour['artworks'][0]))
                    <p><span class="f-headline-editorial t-artwork-title">{{ StringHelpers::truncateStr($my_museum_tour['artworks'][0]['title'], 65) }}</span></p>
                    @isset($my_museum_tour['artworks'][0]['artist_title'])
                        <p><span class="f-body t-artist-title">{{ $my_museum_tour['artworks'][0]['artist_title'] }}</span></p>
                    @endisset
                    @isset($my_museum_tour['artworks'][0]['gallery_title'])
                        <p><span class="f-body t-artist-title">{{ $my_museum_tour['artworks'][0]['gallery_title'] }}</span></p>
                    @endisset
                @endif
            </td>
            <td class="crease" rowspan="11"></td>
            <td rowspan="3">
                @php
                    $imageDims = '684,';
                    $class = '';
                @endphp
                @if(isset($my_museum_tour['artworks'][2]['thumbnail']['width']) && $my_museum_tour['artworks'][2]['thumbnail']['width'] > $my_museum_tour['artworks'][2]['thumbnail']['height'])
                    @php
                        $imageDims = ',684';
                        $class = 'landscape';
                    @endphp
                @endif
                @if(isset($my_museum_tour['artworks'][2]))
                    <div class="artwork-image-container">
                        <img class="{{ $class ?: '' }}" src="https://www.artic.edu/iiif/2/{{ $my_museum_tour['artworks'][2]['image_id'] }}/full/{{ $imageDims }}/0/default.jpg">
                    </div>
                @endif
            </td>
            <td class="gutter" rowspan="3"></td>
            <td colspan="5" class="tombstone">
                @if(isset($my_museum_tour['artworks'][2]))
                    <p><span class="f-headline-editorial t-artwork-title">{{ StringHelpers::truncateStr($my_museum_tour['artworks'][2]['title'], 65) }}</span></p>
                    @isset($my_museum_tour['artworks'][2]['artist_title'])
                        <p><span class="f-body t-artist-title">{{ $my_museum_tour['artworks'][2]['artist_title'] }}</span></p>
                    @endisset
                    @isset($my_museum_tour['artworks'][2]['gallery_title'])
                        <p><span class="f-body t-artist-title">{{ $my_museum_tour['artworks'][2]['gallery_title'] }}</span></p>
                    @endisset
                @endif
            </td>
        </tr>
        <tr>
            <td class="vertical-gutter-short"></td>
            <td colspan="5" class="vertical-gutter-short"></td>
        </tr>
        <tr>
            <td class="short-description">
                @if(isset($my_museum_tour['artworks'][0]))
                    @isset($my_museum_tour['artworks'][0]['description'])
                        <span class="f-body t-short-description">{{ StringHelpers::truncateStr($my_museum_tour['artworks'][0]['description'], 452) }}</span>
                    @endisset
                @endif
            </td>
            <td colspan="5" class="short-description">
                @if(isset($my_museum_tour['artworks'][2]))
                    @isset($my_museum_tour['artworks'][2]['description'])
                        <span class="f-body t-short-description">{{ StringHelpers::truncateStr($my_museum_tour['artworks'][2]['description'], 452) }}</span>
                    @endisset
                @endif
            </td>
        </tr>
        <tr>
            <td colspan="3" class="vertical-gutter-tall"></td>
            <td colspan="7" class="vertical-gutter-tall"></td>
        </tr>
        <tr>
            <td colspan="3" class="c-object-note">
                @isset($my_museum_tour['artworks'][0]['objectNote'])
                    <span class="f-quote t-object-note">&#x201C;{{ $my_museum_tour['artworks'][0]['objectNote'] }}&#x201D;</span>
                @endisset
            </td>
            <td colspan="7" class="c-object-note">
                @isset($my_museum_tour['artworks'][2]['objectNote'])
                    <span class="f-quote t-object-note">&#x201C;{{ $my_museum_tour['artworks'][2]['objectNote'] }}&#x201D;</span>
                @endisset
            </td>
        </tr>
        <tr>
            <td colspan="3" class="vertical-gutter-tall"><div class="artwork-divider"></div></td>
            <td colspan="7" class="vertical-gutter-tall"><div class="artwork-divider"></div></td>
        </tr>
        <tr>
            <td rowspan="3">
                @php
                    $imageDims = '684,';
                    $class = '';
                @endphp
                @if(isset($my_museum_tour['artworks'][1]['thumbnail']['width']) && $my_museum_tour['artworks'][1]['thumbnail']['width'] > $my_museum_tour['artworks'][1]['thumbnail']['height'])
                    @php
                        $imageDims = ',684';
                        $class = 'landscape';
                    @endphp
                @endif
                @if(isset($my_museum_tour['artworks'][1]))
                    <div class="artwork-image-container">
                        <img class="{{ $class ?: '' }}" src="https://www.artic.edu/iiif/2/{{ $my_museum_tour['artworks'][1]['image_id'] }}/full/{{ $imageDims }}/0/default.jpg">
                    </div>
                @endif
            </td>
            <td class="gutter" rowspan="3"></td>
            <td class="tombstone">
                @if(isset($my_museum_tour['artworks'][1]))
                    <p><span class="f-headline-editorial t-artwork-title">{{ StringHelpers::truncateStr($my_museum_tour['artworks'][1]['title'], 65) }}</span></p>
                    @isset($my_museum_tour['artworks'][1]['artist_title'])
                        <p><span class="f-body t-artist-title">{{ $my_museum_tour['artworks'][1]['artist_title'] }}</span></p>
                    @endisset
                    @isset($my_museum_tour['artworks'][1]['gallery_title'])
                        <p><span class="f-body t-artist-title">{{ $my_museum_tour['artworks'][1]['gallery_title'] }}</span></p>
                    @endisset
                @endif
            </td>
            <td rowspan="3">
                @php
                    $imageDims = '684,';
                    $class = '';
                @endphp
                @if(isset($my_museum_tour['artworks'][3]['thumbnail']['width']) && $my_museum_tour['artworks'][3]['thumbnail']['width'] > $my_museum_tour['artworks'][3]['thumbnail']['height'])
                    @php
                        $imageDims = ',684';
                        $class = 'landscape';
                    @endphp
                @endif
                @if(isset($my_museum_tour['artworks'][3]))
                    <div class="artwork-image-container">
                        <img class="{{ $class ?: '' }}" src="https://www.artic.edu/iiif/2/{{ $my_museum_tour['artworks'][3]['image_id'] }}/full/{{ $imageDims }}/0/default.jpg">
                    </div>
                @endif
            </td>
            <td class="gutter" rowspan="3"></td>
            <td colspan="5" class="tombstone">
                @if(isset($my_museum_tour['artworks'][3]))
                    <p><span class="f-headline-editorial t-artwork-title">{{ StringHelpers::truncateStr($my_museum_tour['artworks'][3]['title'], 65) }}</span></p>
                    @isset($my_museum_tour['artworks'][3]['artist_title'])
                        <p><span class="f-body t-artist-title">{{ $my_museum_tour['artworks'][3]['artist_title'] }}</span></p>
                    @endisset
                    @isset($my_museum_tour['artworks'][3]['gallery_title'])
                        <p><span class="f-body t-artist-title">{{ $my_museum_tour['artworks'][3]['gallery_title'] }}</span></p>
                    @endisset
                @endif
            </td>
        </tr>
        <tr>
            <td class="vertical-gutter-short"></td>
            <td colspan="5" class="vertical-gutter-short"></td>
        </tr>
        <tr>
            <td class="short-description">
                @if(isset($my_museum_tour['artworks'][1]))
                    @isset($my_museum_tour['artworks'][1]['description'])
                        <span class="f-body t-short-description">{{ StringHelpers::truncateStr($my_museum_tour['artworks'][1]['description'], 452) }}</span>
                    @endisset
                @endif
            </td>
            <td colspan="5" class="short-description">
                @if(isset($my_museum_tour['artworks'][3]))
                    @isset($my_museum_tour['artworks'][3]['description'])
                        <span class="f-body t-short-description">{{ StringHelpers::truncateStr($my_museum_tour['artworks'][3]['description'], 452) }}</span>
                    @endisset
                @endif
            </td>
        </tr>
        <tr>
            <td colspan="3" class="vertical-gutter-tall"></td>
            <td colspan="7" class="vertical-gutter-tall"></td>
        </tr>
        <tr>
            <td colspan="3" class="c-object-note">
                @isset($my_museum_tour['artworks'][1]['objectNote'])
                    <span class="f-quote t-object-note">&#x201C;{{ $my_museum_tour['artworks'][1]['objectNote'] }}&#x201D;</span>
                @endisset
            </td>
            <td colspan="7" class="c-object-note">
                @isset($my_museum_tour['artworks'][3]['objectNote'])
                    <span class="f-quote t-object-note">&#x201C;{{ $my_museum_tour['artworks'][3]['objectNote'] }}&#x201D;</span>
                @endisset
            </td>
        </tr>
    </tbody>
</table>
@endsection
