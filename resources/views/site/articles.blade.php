@extends('layouts.app')

@section('content')

@php
  $currentCategory = $page->articlesCategories->where('id', request()->query('category'))->pluck('name')->first();
  $currentType = request()->query('type') ? ucfirst(request()->query('type')) : null;
@endphp

<section class="o-articles">

    @component('components.molecules._m-header-block')
      Explore {{ isset($exploreTitle) && $exploreTitle ? $exploreTitle : 'Articles' }}
    @endcomponent
  
    @component('components.molecules._m-links-bar')
        @slot('variation','m-links-bar--articles')
        @slot('primaryHtml')
            <li class="m-links-bar__item m-links-bar__item--primary">
                @component('components.atoms._dropdown')
                  @slot('prompt', isset($currentCategory) ? $currentCategory : 'All categories')
                  @slot('ariaTitle', 'Filter by')
                  @slot('variation','dropdown--filter f-link')
                  @slot('font', null)
                  @slot('options', $categories)
                @endcomponent
            </li>
            <li class="m-links-bar__item m-links-bar__item--primary">
                @component('components.atoms._dropdown')
                  @slot('prompt', isset($currentType) ? $currentType : 'All types')
                  @slot('ariaTitle', 'Filter by')
                  @slot('variation','dropdown--filter f-link')
                  @slot('font', null)
                  @slot('options', $types)
                @endcomponent
            </li>
            @if (isset($currentCategory) || isset($currentType))
              <li class="m-links-bar__item m-links-bar__item--primary">
                  <a href="{{ route('articles') }}" class="f-link">Clear all</a>
              </li>
            @endif
          @endslot
          @slot('secondaryHtml')
              <p class="f-secondary">
                {{ $articlesCount }} items
              </p>
          @endslot
    @endcomponent

  @component('components.atoms._hr')
  @endcomponent

  @if ($articles->isEmpty())
    <div class="m-no-results">
      @component('components.atoms._title')
          @slot('tag','h2')
          @slot('font', 'f-list-3')
          {!! $text ?? 'Sorry, we couldn’t find any results matching your criteria.' !!}
      @endcomponent
    </div>
  @else
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
        @slot('cols_small','2')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @foreach ($articles as $item)
          @if ($item->type == 'video')
            @component('components.molecules._m-listing----media')
              @slot('item', $item)
              @slot('imageSettings', array(
                'fit' => 'crop',
                'ratio' => '16:9',
                'srcset' => array(200,400,600,1000),
                'sizes' => ImageHelpers::aic_gridListingImageSizes(array(
                      'xsmall' => '1',
                      'small' => '2',
                      'medium' => '3',
                      'large' => '4',
                      'xlarge' => '4',
                )),
            ))
            @endcomponent  
          @else
            @component('components.molecules._m-listing----' . Str::slug(strtolower($item->type)) . '-minimal')
              @slot('item', $item)
              @slot('imageSettings', array(
                  'fit' => 'crop',
                  'ratio' => '16:9',
                  'srcset' => array(200,400,600,1000),
                  'sizes' => ImageHelpers::aic_gridListingImageSizes(array(
                        'xsmall' => '1',
                        'small' => '2',
                        'medium' => '3',
                        'large' => '4',
                        'xlarge' => '4',
                  )),
              ))
            @endcomponent
          @endif
        @endforeach
    @endcomponent
  @endif

  @php
    $GLOBALS['paginationAjaxScrollTarget'] = 'listing';
  @endphp
  {!! $articles->links() !!}
  @php
    $GLOBALS['paginationAjaxScrollTarget'] = null;
  @endphp

</section>

@endsection
