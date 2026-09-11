@extends('layouts.app')

@section('content')

@if (!empty($hour))
    @component('components.organisms._o-hours')
        @slot('hour', $hour)
    @endcomponent
@endif

@if ($item->assetLibrary)
    <script type="application/json" id="assetLibrary">
        {!! json_encode($item->assetLibrary) !!}
    </script>
@endif

<article class="o-article{{ (empty($item->description) or $item->description === '') ? ' o-article--no-description' : '' }}" data-behavior="addHistory" data-add-url="{!! route('artworks.addRecentlyViewed', $item) !!}">

  {{-- Gallery-type _m-article-header never renders title --}}
  <h1 class="sr-only">{{ $item->title }}</h1>

  @component('components.molecules._m-article-header')
    @slot('headerType', $item->present()->headerType)
    @slot('title', $item->present()->title)
    @slot('date',  $item->present()->date)
    @slot('type',  $item->present()->type)
    @slot('intro', $item->present()->heading)
    @slot('img',   $item->imageFront('hero'))
    @slot('imgMobile', $item->imageFront('mobile_hero'))
    @slot('galleryImages', $item->galleryImages)
    @slot('isZoomable', !$item->is_deaccessioned && $item->is_zoomable)
    @slot('isPublicDomain', !$item->is_deaccessioned && $item->is_public_domain)
    @slot('maxZoomWindowSize', $item->max_zoom_window_size)
    @slot('prevNextObject', $prevNextObject ?? null)
    @slot('module3d', $model3d ?? null)
    @slot('module360', $item->assetLibrary)
    @slot('moduleMirador', $item->getMiradorManifest())
    @slot('defaultView', $item->getMiradorView())
  @endcomponent

  <div class="o-article__primary-actions o-article__primary-actions--inline-header u-show@large+" aria-label="Additional information">
    {{-- dupe 😢 - shows xlarge+ --}}
    @component('components.atoms._title')
        @slot('variation', 'u-show@large+')
        @slot('tag','h2')
        @slot('font', 'f-module-title-1')
        @slot('ariaHidden', "true")
        {!! $item->present()->getOnViewDisplay() !!}
    @endcomponent

    @if (!$item->is_deaccessioned)
        <ul class="list list--inline f-secondary">
            @if ($item->department_id)
                <li><a href="{!! route('departments.show', [$item->department_id . '/' . StringHelpers::getUtf8Slug($item->department_title)]) !!}" data-gtm-event="{{ $item->department_title }}" data-gtm-event-category="collection-nav">{!! $item->present()->department_title !!}</a></li>
            @endif
            @if ($item->is_on_view && $item->gallery_id)
                <li><a href="{!! route('galleries.show', [$item->gallery_id . '/' . StringHelpers::getUtf8Slug($item->gallery_title)]) !!}" data-gtm-event="{{ $item->gallery_title }}" data-gtm-event-category="collection-nav">{!! $item->present()->gallery_title !!}</a></li>
            @endif
        </ul>
        @if ($item->artwork_website_url)
            <ul class="list list--inline f-secondary">
                <li><a href="{!! $item->artwork_website_url !!}" data-gtm-event="artwork website" data-gtm-event-category="collection-nav">Visit artwork website</a></li>
            </ul>
        @endif
@endif
  </div>

  <div class="o-article__secondary-actions o-article__secondary-actions--inline-header {{ ($item->description !== null && $item->description !== '') ? ' o-article__secondary-actions--with-description' : '' }} u-show@medium+">
    @if (!$item->is_deaccessioned)
        @component('site.shared._loadRelatedSidebar')
            @slot('item', $item)
        @endcomponent
    @endif
  </div>

  <div class="o-article__inline-header">
    @if ($item->title)
      @component('components.atoms._title')
          @slot('tag','span')
          @slot('font', 'f-headline-editorial')
          @slot('variation', 'o-article__inline-header-title')
          @slot('ariaHidden', 'true')
          {!! $item->present()->title !!}
      @endcomponent
    @endif

    @if ($item->date_display)
      <h2 class="sr-only">Date:</h2>
      @component('components.atoms._title')
          @slot('tag','p')
          @slot('font', 'f-secondary')
          @slot('variation', 'o-article__inline-header-display')
          {!! $item->present()->date_display !!}
      @endcomponent
    @endif

    @if ($item->artist_display)
      <h2 class="sr-only">Artist:</h2>
      @component('components.atoms._title')
          @slot('tag','p')
          @slot('font', 'f-secondary')
          @slot('variation', 'o-article__inline-header-display')
          {!! $item->present()->artist_display !!}
      @endcomponent
    @endif

  </div>

  <div class="o-article__body{{ (empty($item->description) or $item->description === '') ? ' o-article__body--no-description' : '' }} o-blocks">

    <h2 class="sr-only">About this artwork</h2>

    @component('components.blocks._blocks')
        @slot('blocks', $item->present()->blocks ?? null)
    @endcomponent

    @component('components.molecules._m-article-actions')
        @slot('variation','m-article-actions--keyline-top')
        @slot('articleType', $item->present()->type)
    @endcomponent
  </div>

</article>

<div class="o-article__secondary-actions o-article__secondary-actions--inline-header {{ ($item->description !== null && $item->description !== '') ? ' o-article__secondary-actions--with-description' : '' }} u-show@small-">
  @if (!$item->is_deaccessioned)
    @component('site.shared._loadRelatedSidebar')
        @slot('item', $item)
    @endcomponent
  @endif
</div>

@if (isset($exploreMoreTags) && $exploreMoreTags->isNotEmpty())
    @component('components.molecules._m-tag-dropdown')
        @slot('tags', $exploreMoreTags)
    @endcomponent
@endif

<div class="explore-more-carousels">
    @php
        $mainArtist = ($item->mainArtist && $item->mainArtist->isNotEmpty()) ? $item->mainArtist->first() : null;
        $styleTitle = $item->style_titles[0] ?? null;
    @endphp

    @if (isset($exploreMoreByArtist) && !empty($mainArtist) && $exploreMoreByArtist->count() > 1)
        @component('components.organisms._o-collection-carousel')
            @slot('headingPrefix', 'MORE WORKS BY ')
            @slot('headingLinkText', $mainArtist->title)
            @slot('headingUrl', route('artists.show', ['id' => $mainArtist->id, 'slug' => $mainArtist->titleSlug]))
            @slot('items', $exploreMoreByArtist)
        @endcomponent
    @endif

    @if (isset($exploreMoreByStyle) && !empty($styleTitle) && $exploreMoreByStyle->count() > 1)
        @component('components.organisms._o-collection-carousel')
            @slot('headingPrefix', 'IN THE STYLE OF ')
            @slot('headingLinkText', $styleTitle)
            @slot('headingUrl', route('collection', ['style_ids' => $styleTitle]))
            @slot('items', $exploreMoreByStyle)
        @endcomponent
    @endif

    @if (isset($exploreMoreByGallery) && $item->is_on_view && !empty($item->gallery_id) && !empty($item->gallery_title) && $exploreMoreByGallery->count() > 1)
        @component('components.organisms._o-collection-carousel')
            @slot('headingPrefix', 'ALSO IN ')
            @slot('headingLinkText', $item->gallery_title)
            @slot('headingUrl', route('collection', ['gallery_ids' => $item->gallery_id]))
            @slot('items', $exploreMoreByGallery)
        @endcomponent
    @endif

    @if (isset($exploreMoreByVisuallySimilar) && $exploreMoreByVisuallySimilar->count() > 1)
        @component('components.organisms._o-collection-carousel')
            @slot('headingPrefix', 'VISUALLY SIMILAR')
            @slot('maxItems', 12)
            @slot('items', $exploreMoreByVisuallySimilar)
        @endcomponent
    @endif
</div>

<div class="o-injected-container" data-behavior="injectContent" data-injectContent-url="{!! route('artworks.recentlyViewed') !!}" data-user-artwork-history></div>

@endsection

@section('extra_scripts')
    <script src="{{FrontendHelpers::revAsset('scripts/blocks360.js')}}"></script>
    <script src="{{FrontendHelpers::revAsset('scripts/mirador.js')}}"></script>
@endsection
