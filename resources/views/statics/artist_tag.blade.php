@extends('layouts.app')

@section('content')

@component('components.molecules._m-header-block')
    {{ $title }}
@endcomponent

@component('components.organisms._o-artist-bio', [ 'bio' => $bio ])
@endcomponent

@component('components.molecules._m-title-bar')
    @slot('variation', 'm-title-bar--secondary')

    Artworks
@endcomponent

@component('components.organisms._o-pinboard')
    @slot('cols_small','2')
    @slot('cols_medium','3')
    @slot('cols_large','4')
    @slot('cols_xlarge','4')
    @slot('cols_xxlarge','4')
    @slot('maintainOrder','true')
    @slot('moreLink',$artworksMoreLink)
    @foreach ($artworks as $artwork)
        @component('components.molecules._m-listing----artwork')
            @slot('variation', 'o-pinboard__item')
            @slot('artwork', $artwork)
        @endcomponent
    @endforeach
@endcomponent


@if ($relatedArticles)
    @component('components.molecules._m-title-bar')
        @slot('variation', 'm-title-bar--secondary')

        Related
    @endcomponent

    @component('components.atoms._hr')
    @endcomponent

    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
        @slot('cols_small','2')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @slot('cols_xxlarge','4')
        @foreach ($relatedArticles as $article)
            @component('components.molecules._m-listing----article')
                @slot('article', $article)
            @endcomponent
        @endforeach
    @endcomponent
@endif

@if ($exploreFuther)
    @component('components.molecules._m-title-bar')
        @slot('variation', 'm-title-bar--secondary')

        Explore Further
    @endcomponent
    @component('components.molecules._m-links-bar')
        @slot('variation', '')
        @slot('linksPrimary', $exploreFuther['nav'])
    @endcomponent
    @component('components.organisms._o-pinboard')
        @slot('cols_small','2')
        @slot('cols_medium','3')
        @slot('cols_large','3')
        @slot('cols_xlarge','3')
        @slot('cols_xxlarge','3')
        @slot('maintainOrder','false')
        @slot('moreLink',$exploreMoreLink)
        @foreach ($exploreFuther['items'] as $item)
            @component('components.molecules._m-listing----'.$item->type)
                @slot('variation', 'o-pinboard__item')
                @slot($item->type, $item)
            @endcomponent
        @endforeach
    @endcomponent
@endif


@if ($exhibitions)
    @component('components.molecules._m-title-bar')
        @slot('variation', 'm-title-bar--secondary')

        Exhibitions
    @endcomponent

    @component('components.atoms._hr')
    @endcomponent

    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
        @slot('cols_small','2')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @slot('cols_xxlarge','4')
        @foreach ($exhibitions as $exhibition)
            @component('components.molecules._m-listing----exhibition')
                @slot('exhibition', $exhibition)
            @endcomponent
        @endforeach
    @endcomponent
@endif


@if ($recentlyViewedArtworks)
    @component('components.molecules._m-title-bar')
        @slot('variation', 'm-title-bar--secondary')
        @slot('links', array(array('label' => 'Clear your history', 'href' => '#')))
        Recently Viewed
    @endcomponent
    @component('components.atoms._hr')
    @endcomponent
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--scroll@medium o-grid-listing--scroll@large o-grid-listing--scroll@xlarge o-grid-listing--scroll@xxlarge o-grid-listing--gridlines-cols')
        @slot('cols_large',(sizeof($recentlyViewedArtworks) > 6) ? '12' : '6')
        @slot('cols_xlarge',(sizeof($recentlyViewedArtworks) > 6) ? '12' : '6')
        @slot('cols_xxlarge',(sizeof($recentlyViewedArtworks) > 6) ? '12' : '6')
        @slot('behavior','dragScroll')
        @foreach ($recentlyViewedArtworks as $artwork)
            @component('components.molecules._m-listing----artwork-minimal')
                @slot('artwork', $artwork)
            @endcomponent
        @endforeach
    @endcomponent
    @component('components.atoms._hr')
        @slot('variation','hr--flush-topp')
    @endcomponent
@endif

@if ($interestedThemes)
    @php
        $themeString = 'You may also like ';
        $themesLength = sizeof($interestedThemes);
        $themesIndex = 1;
        foreach ($interestedThemes as $theme) {
            if ($themesIndex > 1 && $themesIndex < $themesLength) {
                $themeString .= ', ';
            }
            if ($themesIndex === $themesLength) {
                $themeString .= ' and ';
            }
            $themeString .= '<a href="'.$theme['href'].'">'.$theme['label'].'</a>';
            if ($themesIndex === $themesLength) {
                $themeString .= '.';
            }
            $themesIndex++;
        }
    @endphp
    @component('components.blocks._text')
        @slot('variation','interests-list')
        @slot('font','f-list-2')
        @slot('tag','p')
        {!! $themeString !!}
    @endcomponent
@endif

@endsection
