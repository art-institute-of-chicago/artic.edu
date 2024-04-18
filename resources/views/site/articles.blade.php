@extends('layouts.app')

@section('content')

<section class="o-articles">

    @component('components.molecules._m-title-bar')
        @slot('id','listing')
        Explore {{ isset($exploreTitle) && $exploreTitle ? $exploreTitle : 'Articles' }}
    @endcomponent

    @if (isset($categories) && $categories)
        @component('components.molecules._m-links-bar')
            @slot('overflow', true)
            @slot('linksPrimary', $categories)
        @endcomponent
    @endif

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
