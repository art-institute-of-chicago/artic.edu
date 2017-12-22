@extends('layouts.app')

@section('content')

<article class="o-article">

    @component('components.molecules._m-article-header')
      @slot('headerType', 'generic')
      @slot('variation', 'o-article__header')
      @slot('title', $title)
      @slot('img', $headerImage)
      @slot('breadcrumb', $breadcrumb)
    @endcomponent

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

  <div class="o-article__body">
    @component('components.blocks._blocks')
        @slot('blocks', $blocks)
    @endcomponent
  </div>

</article>

@endsection
