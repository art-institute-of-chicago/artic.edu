@extends('layouts.app')

@section('content')

<section class="o-articles">

    @if (isset($heroArticle) && $heroArticle)
        @component('components.organisms._o-features')
            @component('components.molecules._m-listing----article-hero')
                @slot('item', $heroArticle)
                @slot('variation', 'm-listing--hero m-listing--hero-editorial')
                @slot('titleFont', 'f-headline-editorial')
                @slot('captionFont', 'f-secondary')
                @slot('imageSettings', array(
                    'srcset' => array(200,400,600,1000,1500,2000,3000),
                    'sizes' => '100vw',
                ))
            @endcomponent
        @endcomponent
    @endif

  @component('components.molecules._m-title-bar')
      @slot('id','listing')
      Explore Articles
  @endcomponent

  @component('components.molecules._m-links-bar')
      @slot('overflow', true)
      @slot('linksPrimary', $categories)
      @slot('secondaryHtml')
          <li class="m-links-bar__item m-links-bar__item--primary">
              @component('components.atoms._dropdown')
                @slot('prompt', 'Sort by: Date')
                @slot('ariaTitle', 'Sort list by')
                @slot('variation','dropdown--filter f-link')
                @slot('font', null)
                @slot('options', array(
                  array('href' => '#', 'label' => 'Date'),
                  array('href' => '#', 'label' => 'Featured'),
                ))
              @endcomponent
          </li>
      @endslot
  @endcomponent

  @component('components.atoms._hr')
    @slot('variation', 'hr--flush-top')
  @endcomponent

  @component('components.organisms._o-grid-listing')
      @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
      @slot('cols_small','2')
      @slot('cols_medium','2')
      @slot('cols_large','2')
      @slot('cols_xlarge','2')
      @foreach ($featuredArticles as $item)
          @component('components.molecules._m-listing----' . strtolower($item->type))
              @slot('item', $item)
              @slot('titleFont', 'f-list-4')
              @slot('captionFont', 'f-secondary')
              @slot('imageSettings', array(
                  'fit' => 'crop',
                  'ratio' => '16:9',
                  'srcset' => array(200,400,600,1000,1500),
                  'sizes' => aic_gridListingImageSizes(array(
                        'xsmall' => '1',
                        'small' => '2',
                        'medium' => '2',
                        'large' => '2',
                        'xlarge' => '2',
                  )),
              ))
          @endcomponent
      @endforeach
  @endcomponent

  @component('components.atoms._hr')
  @endcomponent

  @component('components.organisms._o-grid-listing')
      @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
      @slot('cols_small','2')
      @slot('cols_medium','3')
      @slot('cols_large','4')
      @slot('cols_xlarge','4')
      @foreach ($articles as $item)
          @component('components.molecules._m-listing----article-minimal')
            @slot('item', $item)
            @slot('imageSettings', array(
                'fit' => 'crop',
                'ratio' => '16:9',
                'srcset' => array(200,400,600,1000),
                'sizes' => aic_gridListingImageSizes(array(
                      'xsmall' => '1',
                      'small' => '2',
                      'medium' => '3',
                      'large' => '4',
                      'xlarge' => '4',
                )),
            ))
          @endcomponent
      @endforeach
  @endcomponent

  @php
    $GLOBALS['paginationAjaxScrollTarget'] = 'listing';
  @endphp
  {!! $articles->links() !!}
  @php
    $GLOBALS['paginationAjaxScrollTarget'] = null;
  @endphp

</section>

@endsection
