@extends('layouts.app')

@section('content')

<article class="o-article">

  @component('components.molecules._m-article-header')
    @slot('editorial', false)
    @slot('headerType', $item->headerType)
    @slot('variation', ($item->headerVariation ?? null))
    @slot('title', $item->title)
    @slot('date', $item->date)
    @slot('type', $item->type)
    @slot('intro', $item->heading)
    @slot('img', $item->imageFront('hero'))
    @slot('galleryImages', $item->galleryImages)
    @slot('nextArticle', $item->nextArticle)
    @slot('prevArticle', $item->prevArticle)
  @endcomponent

  <div class="o-article__primary-actions o-article__primary-actions--inline-header u-show@large+">
    @if ($item->author)
        @component('components.molecules._m-author')
            @slot('variation', 'm-author---keyline-top')
            @slot('editorial', false)
            @slot('img', $item->imageFront('author', 'square'));
            @slot('name', $item->author ?? null);
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

    @if ($item->is_on_view)
        {{-- dupe 😢 - shows xlarge+ --}}
        @component('components.atoms._title')
            @slot('variation', 'u-show@large+')
            @slot('tag','p')
            @slot('font', 'f-module-title-1')
            On View
        @endcomponent
        @component('components.blocks._text')
            @slot('variation', 'u-show@large+')
            @slot('tag','p')
            @slot('font', 'f-secondary')
            <a href="{!! route('galleries.show', [$item->gallery_id]) !!}">{{ $item->isOnViewTitle }}</a>
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

  <div class="o-article__secondary-actions o-article__secondary-actions--inline-header u-show@medium+">

    @if ($item->featuredRelated)
      {{-- dupe 😢 - shows medium+ --}}
      @component('components.blocks._inline-aside')
          @slot('variation', 'u-show@medium+')
          @slot('type', $item->featuredRelated['type'])
          @slot('items', $item->featuredRelated['items'])
          @slot('titleFont', "f-list-1")
          @slot('itemsMolecule', '_m-listing----'.$item->featuredRelated['type'])
          @slot('imageSettings', array(
              'fit' => 'crop',
              'ratio' => '16:9',
              'srcset' => array(200,400,600),
              'sizes' => aic_imageSizes(array(
                    'xsmall' => '0',
                    'small' => '23',
                    'medium' => '18',
                    'large' => '13',
                    'xlarge' => '13',
              )),
          ))
      @endcomponent
    @endif
  </div>

  <div class="o-article__inline-header">
    @if ($item->title)
      @component('components.atoms._title')
          @slot('tag','h1')
          @slot('font', 'f-headline-editorial')
          @slot('variation', 'o-article__inline-header-title')
          {{ $item->title }}
      @endcomponent
    @endif

    @if ($item->subtitle)
      @component('components.atoms._title')
          @slot('tag','p')
          @slot('font', 'f-secondary')
          @slot('variation', 'o-article__inline-header-subtitle')
          {{ $item->subtitle }}
      @endcomponent
    @endif
  </div>

  @if ($item->heading and $item->headerType !== 'super-hero')
  <div class="o-article__intro">
    @component('components.blocks._text')
        @slot('font', 'f-deck')
        {{ $item->heading }}
    @endcomponent
  </div>
  @endif

  @if ($item->featuredRelated)
  {{-- dupe 😢 - hidden medium+ --}}
  <div class="o-article__related">
    @component('components.blocks._inline-aside')
        @slot('type', $item->featuredRelated['type'])
        @slot('items', $item->featuredRelated['items'])
        @slot('titleFont', "f-list-1")
        @slot('itemsMolecule', '_m-listing----'.$item->featuredRelated['type'])
        @slot('imageSettings', array(
            'fit' => 'crop',
            'ratio' => '16:9',
            'srcset' => array(200,400,600),
            'sizes' => aic_imageSizes(array(
                  'xsmall' => '58',
                  'small' => '23',
                  'medium' => '18',
                  'large' => '0',
                  'xlarge' => '0',
            )),
        ))
    @endcomponent
  </div>
  @endif

  <div class="o-article__body o-blocks">

    @component('components.blocks._blocks')
        @slot('blocks', $item->present()->blocks ?? null)
    @endcomponent

    @if ($item->catalogues)
        @component('components.atoms._hr')
        @endcomponent
        @component('components.blocks._text')
            @slot('font', 'f-subheading-1')
            @slot('tag', 'h4')
            Catalogue{{ sizeof($item->catalogues) > 1 ? 's' : '' }}
        @endcomponent
        @foreach ($item->catalogues as $catalogue)
            @component('components.molecules._m-download-file')
                @slot('file', $catalogue)
                @slot('imageSettings', array(
                    'srcset' => array(120,240),
                    'sizes' => '120px',
                ))
            @endcomponent
        @endforeach
    @endif

    @if ($item->pictures)
        @component('components.atoms._hr')
        @endcomponent
        @component('components.blocks._text')
            @slot('font', 'f-subheading-1')
            @slot('tag', 'h4')
            Picture{{ sizeof($item->pictures) > 1 ? 's' : '' }}
        @endcomponent
        @foreach ($item->pictures as $picture)
            @component('components.molecules._m-media')
                @slot('variation', 'o-blocks__block')
                @slot('item', $picture)
                @slot('imageSettings', array(
                    'srcset' => array(300,600,800,1200,1600),
                    'sizes' => aic_imageSizes(array(
                          'xsmall' => '58',
                          'small' => '58',
                          'medium' => '38',
                          'large' => '28',
                          'xlarge' => '28',
                    ))
                ))
            @endcomponent
        @endforeach
    @endif

    @if ($item->otherResources)
        @component('components.atoms._hr')
        @endcomponent
        @component('components.blocks._text')
            @slot('font', 'f-subheading-1')
            @slot('tag', 'h4')
            Other Resource{{ sizeof($item->otherResources) > 1 ? 's' : '' }}
        @endcomponent
        @component('components.molecules._m-link-list')
            @slot('variation', 'm-link-list--download')
            @slot('links', $item->otherResources);
        @endcomponent
    @endif

    @if ($item->speakers)
        @component('components.blocks._text')
            @slot('font', 'f-module-title-2')
            @slot('tag', 'h4')
            Speaker{{ sizeof($item->speakers) > 1 ? 's' : '' }}
        @endcomponent
        @foreach ($item->speakers as $speaker)
            @component('components.molecules._m-row-block')
                @slot('variation', 'm-row-block--inline-title m-row-block--keyline-top')
                @slot('title', $speaker['title'] ?? null)
                @slot('img', $speaker['img'] ?? null)
                @slot('text', $speaker['text'] ?? null)
                @slot('titleFont', 'f-subheading-1')
                @slot('textFont', 'f-body')
                @slot('imageSettings', array(
                    'srcset' => array(200,400,600),
                    'sizes' => aic_imageSizes(array(
                          'xsmall' => '13',
                          'small' => '13',
                          'medium' => '8',
                          'large' => '8',
                          'xlarge' => '8',
                    )),
                ))
            @endcomponent
        @endforeach
    @endif

    @component('components.molecules._m-article-actions')
        @slot('variation','m-article-actions--keyline-top')
        @slot('articleType', $item->type)
    @endcomponent
  </div>

</article>

@if ($exploreFurther)
    @component('components.molecules._m-title-bar')
        Explore Further
    @endcomponent

    @component('shared._explore-further-menu')
        @slot('tags', $exploreFurtherTags)
    @endcomponent

    {{-- Design shows no double bottom line. Commenting this one for now --}}
    {{-- @component('components.atoms._hr')
        @slot('variation','hr--flush-top')
    @endcomponent --}}

    @component('components.organisms._o-pinboard')
        @slot('cols_small','2')
        @slot('cols_medium','3')
        @slot('cols_large','3')
        @slot('cols_xlarge','3')
        @slot('maintainOrder','false')
        @foreach ($exploreFurther as $item)
            @component('components.molecules._m-listing----'.$item->type)
                @slot('variation', 'o-pinboard__item')
                @slot('item', $item)
                @slot('imageSettings', array(
                    'fit' => ($item->type !== 'selection' and $item->type !== 'artwork') ? 'crop' : null,
                    'ratio' => ($item->type !== 'selection' and $item->type !== 'artwork') ? '16:9' : null,
                    'srcset' => array(200,400,600),
                    'sizes' => aic_gridListingImageSizes(array(
                          'xsmall' => '1',
                          'small' => '2',
                          'medium' => '3',
                          'large' => '3',
                          'xlarge' => '3',
                    )),
                ))
            @endcomponent
        @endforeach
    @endcomponent
@endif

@component('components.organisms._o-recently-viewed')
    @slot('artworks',$recentlyViewedArtworks)
@endcomponent

@component('components.organisms._o-interested-themes')
    @slot('themes',$item->interestedThemes)
@endcomponent

@endsection
