@extends('layouts.app')

@section('content')

@php
    $isWideBody = (isset($wideBody) && $wideBody);
@endphp

<article class="o-article o-article--generic-page">

  @component('components.molecules._m-article-header')
    @slot('headerType', 'generic')
    @slot('title', $title)
    @slot('title_display', $title_display ?? null) {{-- WEB-2244: Populate this? --}}
    @slot('img', $headerImage ?? null)
    @slot('breadcrumb', $breadcrumb ?? null)
  @endcomponent

  @if (isset($nav) && !empty($nav))
    <div class="o-article__primary-actions">
        @component('components.organisms._o-collapsing-nav')
            @slot('title', $title)
            @slot('links', $nav);
        @endcomponent
    </div>
  @endif

  @if (!$isWideBody)
      <div class="o-article__secondary-actions">
          @component('components.molecules._m-article-actions')
          @endcomponent

          @if (method_exists($page, 'hasFeaturedRelated') && $page->hasFeaturedRelated())
              @component('site.shared._featuredRelated')
                  @slot('item', $page)
                  @slot('variation', 'u-show@medium+')
              @endcomponent
          @endif
      </div>

      @if (method_exists($page, 'hasFeaturedRelated') && $page->hasFeaturedRelated())
          <div class="o-article__related">
              @component('site.shared._featuredRelated')
                  @slot('item', $page)
              @endcomponent
          </div>
      @endif
  @endif

  <div class="o-article__body o-blocks">
    @if (!empty($intro))
        @component('components.blocks._text')
            @slot('font','f-deck')
            @slot('tag','div')
            {!! SmartyPants::defaultTransform($intro) !!}
        @endcomponent
    @endif
    {!! $page->renderBlocks(false) !!}
    @if (isset($filters) && $filters)
        @component('components.molecules._m-links-bar')
            @slot('variation','m-links-bar--filters')
            @slot('primaryHtml')
                @foreach ($filters as $filter)
                    <li class="m-links-bar__item m-links-bar__item--primary">
                        @component('components.atoms._dropdown')
                          @slot('prompt', $filter['prompt'].': '.$filter['links'][array_search(true, array_column($filter['links'], 'active'))]['label'])
                          @slot('ariaTitle', 'Select decade')
                          @slot('variation','dropdown--filter f-link')
                          @slot('font', null)
                          @slot('options', $filter['links'])
                        @endcomponent
                    </li>
                @endforeach
            @endslot
        @endcomponent
    @endif

    {{-- TODO: This is currently only for Press Releases. Refactor into new template? --}}
    @component('site.shared._sponsors')
        @slot('sponsors', $page->sponsors)
    @endcomponent

    @component('components.molecules._m-article-actions')
        @slot('variation','m-article-actions--keyline-top')
    @endcomponent
  </div>

</article>

@endsection
