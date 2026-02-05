@extends('layouts.app')

@section('content')

@php
    if (request()->query('category')) {
        if (in_array(request()->query('category'), ['videos', 'shorts', 'playlists'], true)) {
            $currentCategory = Str::ucfirst(request()->query('category'));
        }
        else {
            $currentCategory = \App\Models\VideoCategory::where('id', request()->query('category'))->pluck('name')->first();
        }
    }

    $currentDuration = request()->query('duration') ? \App\Models\Video::$durations[request()->query('duration')] : null;
@endphp

<section class="o-articles">

    @component('components.molecules._m-header-block')
      Explore Videos
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
                  @slot('options', $filterCategories)
                @endcomponent
            </li>
            <li class="m-links-bar__item m-links-bar__item--primary">
                @component('components.atoms._dropdown')
                  @slot('prompt', isset($currentDuration) ? $currentDuration : 'Any duration')
                  @slot('ariaTitle', 'Filter by')
                  @slot('variation','dropdown--filter f-link')
                  @slot('font', null)
                  @slot('options', $filterDurations)
                @endcomponent
            </li>
            @if (isset($currentCategory) || isset($currentDuration))
              <li class="m-links-bar__item m-links-bar__item--primary">
                  <a href="{{ route('videos.archive') }}" class="f-link">Clear all</a>
              </li>
            @endif
          @endslot
          @slot('secondaryHtml')
              <p class="f-secondary">
                {{ $videosCount }} items
              </p>
          @endslot
    @endcomponent

  @component('components.atoms._hr')
  @endcomponent

  @if ($videos->isEmpty())
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
        @foreach ($videos as $item)
            @if ($item instanceof \App\Models\Playlist)
                @component('components.molecules._m-listing----playlist-grid-item')
                    @slot('playlist', $item)
                    @slot('imageSettings', array(
                        'fit' => 'crop',
                        'ratio' => '16:9',
                        'srcset' => array(200,400,600),
                        'sizes' => ImageHelpers::aic_imageSizes(array(
                            'xsmall' => '216px',
                            'small' => '216px',
                            'medium' => '18',
                            'large' => '13',
                            'xlarge' => '13',
                        )),
                    ))
                @endcomponent
            @else
                @component('components.molecules._m-listing----grid-item')
                    @slot('url', $item->url ?? '')
                    @slot('image', ['src' => $item->thumbnail_url ?? ''])
                    @slot('label', $item->duration_display ?? '')
                    @slot('labelPosition', 'overlay')
                    @slot('title', $item->title ?? '')
                    @slot('imageSettings', array(
                        'fit' => 'crop',
                        'ratio' => '16:9',
                        'srcset' => array(200,400,600),
                        'sizes' => ImageHelpers::aic_imageSizes(array(
                            'xsmall' => '216px',
                            'small' => '216px',
                            'medium' => '18',
                            'large' => '13',
                            'xlarge' => '13',
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
  {!! $videos->links() !!}
  @php
    $GLOBALS['paginationAjaxScrollTarget'] = null;
  @endphp

</section>

@endsection
