@extends('layouts.app')

@section('content')

@php
  $currentCategory = $page->articlesCategories->where('id', request()->query('category'))->pluck('name')->first();
  $currentType = request()->query('type') ? ucfirst(request()->query('type')) : null;
@endphp

<section class="o-articles">

    @component('components.molecules._m-title-bar')
        @slot('id','listing')
        @slot('variation', 'stories-listing')
        Explore {{ isset($exploreTitle) && $exploreTitle ? $exploreTitle : 'all stories' }}
    @endcomponent

    <div class="stories-header-filters">

    @if (isset($categories) && $categories)
      @component('components.atoms._dropdown')
        @slot('prompt', isset($currentCategory) ? $currentCategory : 'All categories')
        @slot('ariaTitle', 'Filter by')
        @slot('options', $categories)
      @endcomponent
    @endif

    @if (isset($types) && $types)
      @component('components.atoms._dropdown')
        @slot('prompt', isset($currentType) ? $currentType : 'All types')
        @slot('ariaTitle', 'Filter by')
        @slot('options', $types)
      @endcomponent
    @endif

    @if (isset($currentCategory) || isset($currentType))
      @component('components.atoms._link')
        @slot('href', route('articles'))
        @slot('label', 'Reset filters')
        Clear filters
      @endcomponent
    @endif

    </div>

    <br>

    <p class="stories-count">{{ $articlesCount > 0 ? $articlesCount.' items' : '' }}</p>

  @component('components.atoms._hr')
  @endcomponent

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

  @php
    $GLOBALS['paginationAjaxScrollTarget'] = 'listing';
  @endphp
  {!! $articles->links() !!}
  @php
    $GLOBALS['paginationAjaxScrollTarget'] = null;
  @endphp

</section>

@endsection
