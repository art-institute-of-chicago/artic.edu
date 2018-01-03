@extends('layouts.app')

@section('content')

<article class="o-article">

  @component('components.molecules._m-article-header')
    @slot('headerType', ($article->headerType ?? null))
    @slot('variation', 'o-article__header')
    @slot('title', $article->title)
    @slot('date', $article->date)
    @slot('type', $article->type)
    @slot('intro', $article->intro)
    @slot('img', $article->headerImage)
  @endcomponent

  <div class="o-article__primary">
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

    @component('components.blocks._blocks')
        @slot('blocks', $article->blocks)
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
