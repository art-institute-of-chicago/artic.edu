@extends('layouts.app')

@section('content')

@php
    $isWideBody = (isset($wideBody) && $wideBody);
@endphp

<article class="o-article o-article--generic-page">

  @component('components.molecules._m-article-header')
    @slot('headerType', 'generic')
    @slot('variation', 'o-article__header')
    @slot('title', $title)
    @slot('img', $headerImage ?? null)
    @slot('breadcrumb', $breadcrumb ?? null)
  @endcomponent

  <div class="o-article__primary-actions">
    @component('components.atoms._dropdown')
      @slot('prompt', $title)
      @slot('variation', 'dropdown--filter u-hide@large+')
      @slot('ariaTitle', 'Sub navigation')
      @slot('options', $subNav)
    @endcomponent

    @component('components.molecules._m-link-list')
        @slot('font', 'f-module-title-1')
        @slot('variation','u-show@large+')
        @slot('links', $nav);
    @endcomponent
  </div>

  @if (!$isWideBody)
      <div class="o-article__secondary-actions">
        @component('components.molecules._m-article-actions')
        @endcomponent

        @if (isset($featuredRelated) and $featuredRelated)
            {{-- dupe 😢 - shows medium+ --}}
            @component('components.blocks._inline-aside')
                @slot('variation', 'u-show@medium+')
                @slot('type', $featuredRelated['type'])
                @slot('items', $featuredRelated['items'])
                @slot('itemsMolecule', '_m-listing----'.$featuredRelated['type'])
            @endcomponent
        @endif
      </div>


      @if (isset($featuredRelated) and $featuredRelated)
        {{-- dupe 😢 - hidden medium+ --}}
        <div class="o-article__related">
            @component('components.blocks._inline-aside')
                @slot('type', $featuredRelated['type'])
                @slot('items', $featuredRelated['items'])
                @slot('itemsMolecule', '_m-listing----'.$featuredRelated['type'])
            @endcomponent
        </div>
      @endif
  @endif

  <div class="o-article__body o-blocks">
    @if (isset($filters) && $filters)
        @component('components.molecules._m-links-bar')
            @slot('variation','m-links-bar--filters')
            @slot('primaryHtml')
                @foreach ($filters as $filter)
                    <li class="m-links-bar__item m-links-bar__item--primary">
                        @component('components.atoms._dropdown')
                          @slot('prompt', $filter['prompt'].': '.$filter['links'][array_search(true, array_column($filter['links'], 'active'))]['label'])
                          @slot('ariaTitle', 'Select decade')
                          @slot('variation','dropdown--filter f-buttons')
                          @slot('font', 'f-buttons')
                          @slot('options', $filter['links'])
                        @endcomponent
                    </li>
                @endforeach
            @endslot
        @endcomponent
    @endif
    @component('components.blocks._blocks')
        @slot('blocks', $blocks ?? null)
    @endcomponent

    @if (isset($listingItems) and $listingItems)
        @if (isset($listingCountText) and $listingCountText)
            @component('components.molecules._m-listing-header')
                @slot('count', $listingCountText)
            @endcomponent
        @endif
        @component('components.atoms._hr')
        @endcomponent
        @component('components.organisms._o-row-listing')
            @foreach ($listingItems as $item)
                @component('components.molecules._m-listing----generic-row')
                    @slot('variation', 'm-listing--generic m-listing--row')
                    @slot('item', $item)
                @endcomponent
            @endforeach
        @endcomponent
        @component('components.molecules._m-paginator')
        @endcomponent
    @endif

    @component('components.molecules._m-article-actions')
        @slot('variation','m-article-actions--keyline-top')
    @endcomponent
  </div>

</article>

@endsection
