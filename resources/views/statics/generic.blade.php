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
      @slot('prompt', $title)
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
    @component('components.molecules._m-article-actions')
    @endcomponent

    @if ($featuredRelated)
        @component('components.blocks._inline-aside')
            @slot('variation', 'u-show@medium+')
            @slot('type', $featuredRelated['type'])
            @slot('items', $featuredRelated['items'])
            @slot('itemsMolecule', '_m-listing----'.$featuredRelated['type'])
        @endcomponent
    @endif
  </div>

  @if ($featuredRelated)
      @component('components.blocks._inline-aside')
          @slot('variation', 'u-show@small')
          @slot('type', $featuredRelated['type'])
          @slot('items', $featuredRelated['items'])
          @slot('itemsMolecule', '_m-listing----'.$featuredRelated['type'])
      @endcomponent
  @endif

  <div class="o-article__body">
    @component('components.blocks._blocks')
        @slot('blocks', $blocks)
    @endcomponent
    @component('components.molecules._m-article-actions')
        @slot('variation','m-article-actions--keyline-top')
    @endcomponent
  </div>

</article>

@endsection
