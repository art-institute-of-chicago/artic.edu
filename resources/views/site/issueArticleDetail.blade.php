@extends('layouts.app')

@section('content')

<article class="o-article">

  @component('components.molecules._m-article-header')
    @slot('editorial', ($item->articleType === 'editorial'))
    @slot('headerType', $item->present()->headerType)
    @slot('variation', ($item->headerVariation ?? null))
    @slot('title', $item->present()->title)
    @slot('title_display', $item->present()->title_display)
    @slot('date', $item->date)
    @slot('type', $item->present()->subtype)
    @slot('intro', $item->present()->heading)
    @slot('img', $item->imageFront('hero'))
    @slot('galleryImages', $item->galleryImages)
    @slot('nextArticle', $item->nextArticle)
    @slot('prevArticle', $item->prevArticle)
  @endcomponent

  <div class="o-article__primary-actions">
    @component('components.molecules._m-article-actions')
        @slot('articleType', $item->articleType)
    @endcomponent

    @if ($item->author)
        @component('components.molecules._m-author')
            @slot('variation', 'm-author---keyline-top')
            @slot('editorial', ($item->articleType === 'editorial'))
            @slot('img', $item->imageFront('author', 'square'));
            @slot('name', $item->present()->author ?? null);
            @slot('link', null);
            @slot('date', $item->date ?? null);
        @endcomponent
    @endif

    @if ($item->nav)
        {{-- dupe 😢 - shows xlarge+ --}}
        @component('components.molecules._m-link-list')
            @slot('variation', 'u-show@large+')
            @slot('links', $item->nav);
        @endcomponent
    @endif
  </div>

  {{-- dupe 😢 - hides xlarge+ --}}
  @if ($item->nav)
  <div class="o-article__meta">
    @if ($item->nav)
        @component('components.molecules._m-link-list')
            @slot('links', $item->nav);
        @endcomponent
    @endif
  </div>
  @endif

  <div class="o-article__secondary-actions">
    @component('site.shared._featuredRelated')
        @slot('featuredRelated', $item->featuredRelated ?? null)
        @slot('variation', 'u-show@medium+')
    @endcomponent
  </div>

  @if ($item->heading and $item->headerType !== 'super-hero')
  <div class="o-article__intro">
    @component('components.blocks._text')
        @slot('font', 'f-deck')
        @slot('tag', 'span')
        {!! $item->present()->heading !!}
    @endcomponent
  </div>
  @endif

  {{-- For articles, this shows below body, not float-right --}}
  @if ($item->featuredRelated)
      <div class="o-article__related">
        @component('site.shared._featuredRelated')
            @slot('featuredRelated', $item->featuredRelated ?? null)
        @endcomponent
      </div>
  @endif

  <div class="o-article__body o-blocks">

    @php
        global $_collectedReferences;
        $_collectedReferences = [];

        global $_paragraphCount;
        $_paragraphCount = app()->environment('production') ? null : 0;

        global $_figureCount;
        $_figureCount = app()->environment('production') ? null : 0;
    @endphp

    {!! $item->renderBlocks(false, [], [
      'pageTitle' => $item->meta_title ?: $item->title
    ]) !!}

    @if (sizeof($_collectedReferences))
        @component('components.organisms._o-accordion')
            @slot('variation', 'o-accordion--section o-blocks__block')
            @slot('items', array(
                array(
                    'title' => "References",
                    'active' => true,
                    'blocks' => array(
                        array(
                            "type" => 'references',
                            "items" => $_collectedReferences
                        ),
                    ),
                ),
            ))
            @slot('loopIndex', 'references')
        @endcomponent
    @endif

    @component('components.molecules._m-article-actions')
        @slot('variation','m-article-actions--keyline-top')
        @slot('articleType', $item->articleType)
    @endcomponent
  </div>

</article>

@if (isset($featuredArticles) && $featuredArticles)
    @component('components.molecules._m-title-bar')
        Further Reading
    @endcomponent
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @slot('behavior','dragScroll')
        @foreach ($featuredArticles as $item)
            @component('components.molecules._m-listing----' . strtolower($item->type))
                @slot('item', $item)
                @slot('imageSettings', array(
                    'fit' => 'crop',
                    'ratio' => '16:9',
                    'srcset' => array(200,400,600),
                    'sizes' => aic_imageSizes(array(
                          'xsmall' => '216px',
                          'small' => '216px',
                          'medium' => '18',
                          'large' => '13',
                          'xlarge' => '13',
                    )),
                ))
            @endcomponent
        @endforeach
    @endcomponent
@endif

<div class="o-injected-container" data-behavior="injectContent" data-injectContent-url="{!! route('artworks.recentlyViewed') !!}" data-user-artwork-history></div>

@endsection
