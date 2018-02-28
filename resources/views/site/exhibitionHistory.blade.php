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

    @component('components.molecules._m-links-bar')
        @slot('variation','m-links-bar--filters')
        @slot('primaryHtml')
            <li class="m-links-bar__item m-links-bar__item--primary">
                @component('components.atoms._dropdown')
                  @slot('prompt', 'Decade: '.$decade_prompt)
                  @slot('ariaTitle', 'Select decade')
                  @slot('variation','dropdown--filter f-buttons')
                  @slot('font', 'f-buttons')
                  @slot('options', $decades)
                @endcomponent
            </li>
            <li class="m-links-bar__item m-links-bar__item--primary">
                @component('components.atoms._dropdown')
                  @slot('prompt', 'Year: '.$year)
                  @slot('ariaTitle', 'Select decade')
                  @slot('variation','dropdown--filter f-buttons')
                  @slot('font', 'f-buttons')
                  @slot('options', $years)
                @endcomponent
            </li>
            <li class="m-links-bar__item m-links-bar__item--search">
                @component('components.molecules._m-search-bar')
                    @slot('variation', 'm-search-bar--subtle')
                    @slot('placeholder','Keyword')
                    @slot('name', 'keyword')
                    @slot('action', '/statics/exhibition_history')
                    @slot('clearLink', '/statics/exhibition_history')
                    @slot('value', $_GET['keyword'] ?? null)
                @endcomponent
            </li>
        @endslot
    @endcomponent

    @component('components.molecules._m-title-bar')
        @slot('links', array(array('label' => 'Showing 10 out of 23 Exhibitions', 'href' => '#')))
        @slot('titleFont', 'f-numeral-date')
        {{ $year }}
    @endcomponent

    @component('components.atoms._hr')
    @endcomponent

    @component('components.organisms._o-row-listing')
        @foreach ($exhibitions as $item)
            @component('components.molecules._m-listing----exhibition-history-row')
                @slot('variation', 'm-listing--row')
                @slot('item', $item)
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
            @foreach ($recentlyViewedArtworks as $item)
                @component('components.molecules._m-listing----artwork-minimal')
                    @slot('item', $item)
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
