@extends('layouts.app')

@section('content')

<article class="o-article">

  <header class="o-article__header m-article-header">
    @component('components.atoms._title')
        @slot('tag','h1')
        @slot('font','f-headline')
        Making Place: the Architecture of David Adjaye
    @endcomponent
    @component('components.atoms._date')
        @slot('tag','p')
        September 19 2015 - January 3 2016
    @endcomponent
    @component('components.atoms._type')
        @slot('tag','p')
        Exhibition
    @endcomponent
  </header>

  <header class="o-article__header m-article-header m-article-header--feature">
    <div class="m-article-header__img">
        @component('components.atoms._img')
            @slot('src', $headerImage['src'])
            @slot('width', $headerImage['width'])
            @slot('height', $headerImage['height'])
        @endcomponent
    </div>
    <div class="m-article-header__text" style="background-image: url({{ $headerImage['src'] }});">
        @component('components.atoms._title')
            @slot('tag','h1')
            @slot('font','f-headline')
            Making Place: the Architecture of David Adjaye
        @endcomponent
        @component('components.atoms._date')
            @slot('tag','p')
            September 19 2015 - January 3 2016
        @endcomponent
        @component('components.atoms._type')
            @slot('tag','p')
            Exhibition
        @endcomponent
    </div>
  </header>

  <header class="o-article__header m-article-header m-article-header--hero">
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
            @slot('font','f-display-2')
            Making Place: the Architecture of David Adjaye
        @endcomponent
        @component('components.atoms._date')
            @slot('tag','p')
            September 19 2015 - January 3 2016
        @endcomponent
        @component('components.atoms._type')
            @slot('tag','p')
            Special Exhibition
        @endcomponent
        @component('components.atoms._hr')
        @endcomponent
        @component('components.blocks._text')
            @slot('font','f-deck')
            @slot('variation', 'm-article-header__intro')
            Deck sit amet, consectetur adipiscing elit. Curabitur magna neque, laoreet at tristique et, dignissim condimentum enim. Proin cursus diam nec nibh fermentum, eget consequat arcu efficitur
        @endcomponent
    </div>
  </header>

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

  <div class="o-article__primary">
    @component('components.atoms._hr')
    @endcomponent

    @component('components.molecules._m-article-actions')
        @slot('variation','m-article-actions--keyline-top')
    @endcomponent

    @component('components.atoms._hr')
    @endcomponent

    <p class="f-secondary"><svg class="icon--location" aria-hidden="true"><use xlink:href="#icon--location" /></svg> Galleries 182-184</p>
  </div>

  <div class="o-article__secondary">
    @component('components.atoms._hr')
        @slot('variation', 'u-hide@medium+')
    @endcomponent
    <p>
        @component('components.atoms._btn')
            @slot('variation', 'btn--full')
            @slot('tag', 'a')
            @slot('href', '#')
            Buy tickets
        @endcomponent
        <br>
        @component('components.atoms._btn')
            @slot('variation', 'btn--secondary btn--full')
            @slot('tag', 'a')
            @slot('href', '#')
            Become a member
        @endcomponent
    </p>
    <p class="f-secondary">Exhibitions are free with museum admission.</p>
  </div>

  <div class="o-article__body" data-behavior="articleBodyInViewport">
    @component('components.atoms._hr')
    @endcomponent

    @component('components.blocks._inline-aside')
        @component('components.molecules._m-aside-newsletter')
            @slot('variation','m-aside-newsletter--inline')
            @slot('placeholder','Email Address')
        @endcomponent
    @endcomponent

    @component('components.blocks._blocks')
        @slot('blocks', $blocks)
    @endcomponent

  </div>

  <div class="o-article__tertiary">
    <p class="o-article__tertiary-titles">
        @component('components.atoms._date')
            @slot('font','f-body')
            Making Place: the Architecture of David Adjaye
        @endcomponent
        <br>
        @component('components.atoms._date')
            September 19 2015 - January 3 2016
        @endcomponent
    </p>
    <p class="o-article__tertiary-actions">
        @component('components.atoms._btn')
            @slot('variation', 'btn--full')
            @slot('tag', 'a')
            @slot('href', '#')
            Buy tickets
        @endcomponent
    </p>
  </div>

    @component('components.atoms._btn')
        @slot('variation', 'btn--icon arrow-link--up o-article__top-link')
        @slot('font', '')
        @slot('icon', 'icon--arrow')
        @slot('behavior', 'topLink')
        @slot('tag', 'a')
        @slot('href', '#a17')
    @endcomponent

</article>

@endsection
