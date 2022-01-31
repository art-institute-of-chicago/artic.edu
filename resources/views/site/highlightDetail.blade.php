@extends('layouts.app')

@section('content')

<article class="o-article{{ ($item->articleType === 'editorial') ? ' o-article--editorial' : '' }}">

  @component('components.molecules._m-article-header')
    @slot('editorial', false)
    @slot('headerType', $item->present()->headerType)
    @slot('variation', ($item->headerVariation ?? null))
    @slot('title', $item->present()->title)
    @slot('title_display', $item->present()->title_display)
    @slot('type', $item->present()->type)
    @slot('img', $item->imageFront('hero'))
    @slot('imgMobile', $item->imageFront('mobile_hero'))
    @slot('credit', $item->present()->hero_caption)
  @endcomponent

  <div class="o-article__primary-actions{{ ($item->headerType === 'gallery') ? ' o-article__primary-actions--inline-header' : '' }}{{ ($item->articleType === 'artwork') ? ' u-show@large+' : '' }}">
    @if ($item->articleType !== 'artwork')
        @component('components.molecules._m-article-actions')
            @slot('articleType', $item->articleType)
        @endcomponent
    @endif
  </div>

  <div class="o-article__secondary-actions">
    @component('site.shared._featuredRelated')
        @slot('item', $item)
        @slot('variation', 'u-show@medium+')
    @endcomponent
  </div>

  @if ($item->hasFeaturedRelated())
    <div class="o-article__related">
        @component('site.shared._featuredRelated')
            @slot('item', $item)
        @endcomponent
    </div>
  @endif

  @if ($item->short_copy)
        <div class="o-article__intro">
          @component('components.blocks._text')
              @slot('font', 'f-deck')
              @slot('tag', 'div')
              {!! $item->present()->short_copy !!}
          @endcomponent
        </div>
    @endif

  <div class="o-article__body o-blocks">
    @php
        global $_collectedReferences;
        $_collectedReferences = [];
    @endphp
    {!! $item->renderBlocks(false) !!}
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

@component('site.shared._relatedItems')
    @slot('title', $furtherReadingTitle ?? null)
    @slot('relatedItems', $furtherReadingItems ?? null)
@endcomponent

@if ($exploreFurther || $exploreFurtherAllTags)
<div id="exploreFurther">
    @component('components.molecules._m-title-bar')
        Explore Further
    @endcomponent

    @component('site.shared._explore-further-menu')
        @slot('tags', $exploreFurtherTags)
    @endcomponent

    @if ($exploreFurther && !$exploreFurther->isEmpty() && !$exploreFurtherAllTags)
        @component('components.organisms._o-pinboard----artwork')
            @slot('artworks', $exploreFurther)
            @slot('sizes', [
                'xsmall' => '1',
                'small' => '2',
                'medium' => '3',
                'large' => '3',
                'xlarge' => '3',
            ])
        @endcomponent
    @endif

    @if ($exploreFurtherAllTags)
        @component('components.molecules._m-multi-col-list')
            @slot('cols_small','2')
            @slot('cols_medium','3')
            @slot('cols_large','4')
            @slot('cols_xlarge','4')
            @slot('items', $exploreFurtherAllTags)
        @endcomponent
    @endif

    @if ($exploreFurtherCollectionUrl)
        @component('components.molecules._m-links-bar')
            @slot('variation', 'm-links-bar--buttons')
            @slot('linksPrimary', [
                [
                    'label' => 'See more results',
                    'href' => $exploreFurtherCollectionUrl,
                    'variation' => 'btn--tertiary'
                ]
            ])
        @endcomponent
    @endif
</div>
@endif

<div class="o-injected-container" data-behavior="injectContent" data-injectContent-url="{!! route('artworks.recentlyViewed') !!}" data-user-artwork-history></div>

@endsection

@section('extra_scripts')
    <script src="{{FrontendHelpers::revAsset('scripts/blocks3D.js')}}"></script>
    <script src="{{FrontendHelpers::revAsset('scripts/virtualTour.js')}}"></script>
    <script src="/virtual-tours/tour.js"></script>
    <script src="{{FrontendHelpers::revAsset('scripts/videojs.js')}}"></script>
@endsection
