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

  <div class="o-article__primary-actions{{ ($item->headerType === 'gallery') ? ' o-article__primary-actions--inline-header' : '' }}{{ ($item->articleType === 'artwork') ? ' u-show@large+' : '' }}">
    @if ($item->articleType !== 'artwork')
        @component('components.molecules._m-article-actions')
            @slot('articleType', $item->articleType)
        @endcomponent
    @endif

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

  <div class="o-article__secondary-actions{{ ($item->headerType === 'gallery') ? ' o-article__secondary-actions--inline-header' : '' }}{{ ($item->articleType === 'artwork') ? ' u-show@medium+' : '' }}">
    @component('site.shared._featuredRelated')
        @slot('featuredRelated', $item->featuredRelated ?? null)
        @slot('variation', 'u-show@medium+')
    @endcomponent
  </div>

  @if ($item->headerType === 'gallery')
  <div class="o-article__inline-header">
    @if ($item->title)
      @component('components.atoms._title')
          @slot('tag','h1')
          @slot('font', 'f-headline-editorial')
          @slot('variation', 'o-article__inline-header-title')
          @slot('title', $item->present()->title)
          @slot('title_display', $item->present()->title_display)
      @endcomponent
    @endif

    @if ($item->subtitle)
      @component('components.atoms._title')
          @slot('tag','p')
          @slot('font', 'f-secondary')
          @slot('variation', 'o-article__inline-header-subtitle')
          {!! $item->present()->subtitle !!}
      @endcomponent
    @endif
  </div>
  @endif

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

  </div>

</article>

<div class="o-injected-container" data-behavior="injectContent" data-injectContent-url="{!! route('artworks.recentlyViewed') !!}" data-user-artwork-history></div>

@endsection
