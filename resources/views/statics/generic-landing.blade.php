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
            Students
        @endcomponent
        <ul class="m-article-header__breadcrumb" style="background-image: url({{ $headerImage['src'] }});">
            <li class="f-secondary">
                @component('components.atoms._arrow-link')
                    @slot('font','f-null')
                    @slot('href','#')
                    Visit
                @endcomponent
            </li>
            <li class="f-secondary">
                @component('components.atoms._arrow-link')
                    @slot('font','f-null')
                    @slot('href','#')
                    Group Visits
                @endcomponent
            </li>
            <li class="f-secondary">
                Students
            </li>
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

    @component('components.blocks._text')
        Lorem sit amet, consectetur adipiscing elit. Curabitur magna neque, laoreet at tristique et, dignissim condimentum enim. Proin cursus diam nec nibh fermentum, eget consequat arcu efficitur
    @endcomponent

  </div>

</article>

@endsection
