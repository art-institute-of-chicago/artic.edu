@extends('layouts.app')

@section('content')

    @component('components.molecules._m-header-block')
        {{ $title }}
    @endcomponent

    @component('components.molecules._m-intro-block')
        {!! $intro !!}
    @endcomponent

    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--gridlines-rows')
        @slot('cols_medium','2')
        @slot('cols_large','2')
        @slot('cols_xlarge','2')
        @slot('tag', 'div')

        <div class="o-blocks">
          @component('components.molecules._m-media')
            @slot('item', $media)
          @endcomponent
        </div>
        <div class="o-blocks">
            @component('components.blocks._blocks')
                @slot('blocks', $blocks)
            @endcomponent
        </div>
    @endcomponent


    <nav class="m-links-bar">
      <ul class="m-links-bar__items-primary">

        <li class="m-links-bar__item m-links-bar__item--primary">
            @component('components.atoms._dropdown')
              @slot('prompt', 'Decade: 2010-2017')
              @slot('ariaTitle', 'Select decade')
              @slot('variation','dropdown--filter f-buttons')
              @slot('font', 'f-buttons')
              @slot('options', array(
                array('href' => '#', 'label' => '2010-2017'),
                array('href' => '#', 'label' => '2000-2009'),
                array('href' => '#', 'label' => '1990-1999'),
                array('href' => '#', 'label' => '1980-1989'),
                array('href' => '#', 'label' => '1970-1979'),
                array('href' => '#', 'label' => '1960-1969'),
              ))
            @endcomponent
        </li>
        <li class="m-links-bar__item m-links-bar__item--primary">
            @component('components.atoms._dropdown')
              @slot('prompt', 'Year: 2017')
              @slot('ariaTitle', 'Select decade')
              @slot('variation','dropdown--filter f-buttons')
              @slot('font', 'f-buttons')
              @slot('options', array(
                array('href' => '#', 'label' => '2017'),
                array('href' => '#', 'label' => '2016'),
                array('href' => '#', 'label' => '2015'),
                array('href' => '#', 'label' => '2014'),
                array('href' => '#', 'label' => '2013'),
                array('href' => '#', 'label' => '2012'),
                array('href' => '#', 'label' => '2011'),
                array('href' => '#', 'label' => '2010'),
              ))
            @endcomponent
        </li>
        <li class="m-links-bar__item m-links-bar__item--search">
            @component('components.molecules._m-search-bar')
                @slot('variation', 'm-search-bar--subtle')
                @slot('placeholder','Keyword')
                @slot('name', 'exhibition-history-search')
            @endcomponent
        </li>

      </ul>
    </nav>

    @component('components.molecules._m-title-bar')
        @slot('links', array(array('label' => 'Showing 10 out of 23 Exhibitions', 'href' => '#')))
        2017
    @endcomponent

    @component('components.atoms._hr')
    @endcomponent

    @component('components.organisms._o-row-listing')
        @foreach ($exhibitions as $exhibition)
            @component('components.molecules._m-listing----exhibition-row')
                @slot('variation', 'm-listing--row')
                @slot('exhibition', $exhibition)
            @endcomponent
        @endforeach
    @endcomponent

    @component('components.molecules._m-paginator')
    @endcomponent

    @if ($recentlyViewedArtworks)
        @component('components.molecules._m-title-bar')
            @slot('links', array(array('label' => 'Clear your history', 'href' => '#')))
            Recently Viewed
        @endcomponent
        @component('components.atoms._hr')
        @endcomponent
        @component('components.organisms._o-grid-listing')
            @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--scroll@medium o-grid-listing--scroll@large o-grid-listing--scroll@xlarge  o-grid-listing--gridlines-cols')
            @slot('cols_large',(sizeof($recentlyViewedArtworks) > 6) ? '12' : '6')
            @slot('cols_xlarge',(sizeof($recentlyViewedArtworks) > 6) ? '12' : '6')
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
            $themeString = 'It seems it you could also be interested in ';
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
