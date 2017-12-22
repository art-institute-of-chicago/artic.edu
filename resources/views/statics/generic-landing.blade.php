@extends('layouts.app')

@section('content')

<article class="o-article">

  <header class="o-article__header m-article-header m-article-header--generic">
    <div class="m-article-header__img">
        @component('components.atoms._img')
            @slot('src', $headerImage['src'])
            @slot('width', $headerImage['width'])
            @slot('height', $headerImage['height'])
        @endcomponent
    </div>
    <div class="m-article-header__text">
        @component('components.atoms._title')
            @slot('tag','h1')
            @slot('font','f-headline')
            {{ $title }}
        @endcomponent
        <ul class="m-article-header__breadcrumb" style="background-image: url({{ $headerImage['src'] }});">
            @foreach ($breadcrumb as $link)
                @if ($loop->last)
                    <li class="f-secondary">
                        {{ $link['label'] }}
                    </li>
                @else
                    <li class="f-secondary">
                        @component('components.atoms._arrow-link')
                            @slot('font','f-null')
                            @slot('href',$link['href'])
                            {{ $link['label'] }}
                        @endcomponent
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
  </header>

  <div class="o-article__primary o-article__primary--sub-nav">
    @component('components.atoms._dropdown')
      @slot('prompt', 'Scheduling a tour')
      @slot('variation', 'dropdown--filter u-hide@xlarge+')
      @slot('ariaTitle', 'Sub navigation')
      @slot('options', $subNav)
    @endcomponent

    @component('components.molecules._m-link-list')
        @slot('font', 'f-module-title-1')
        @slot('variation','u-show@xlarge+')
        @slot('links', $nav);
    @endcomponent
  </div>

  <div class="o-article__secondary">
    @component('components.atoms._hr')
        @slot('variation', 'u-hide@medium+')
    @endcomponent
    <p>
        @component('components.atoms._btn')
            @slot('variation', 'btn--icon')
            @slot('font', '')
            @slot('icon', 'icon--share--24')
            @slot('behavior','sharePage')
        @endcomponent
        @component('components.atoms._btn')
            @slot('variation', 'btn--secondary btn--icon')
            @slot('font', '')
            @slot('icon', 'icon--print--24')
            @slot('behavior','printPage')
        @endcomponent
    </p>
  </div>

  <div class="o-article__body" data-behavior="articleBodyInViewport">

    @foreach ($blocks as $block)
        @if ($block['type'] === 'text')
            @php
                $font = false;
                $variation = false;
                $tag = false;
                //
                if (isset($block['subtype'])) {
                    $font = ($block['subtype'] === 'intro') ? 'f-deck' : $font;
                }
            @endphp
            @component('components.blocks._text')
                @slot('tag', ($tag ? $tag : null))
                @slot('variation', ($variation ? $variation : null))
                @slot('font', ($font ? $font : null))
                {{ $block['content'] }}
            @endcomponent
        @endif
    @endforeach

  </div>

</article>

@endsection
