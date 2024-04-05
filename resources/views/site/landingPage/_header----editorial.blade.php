@php
    $newHoursStartAt = Carbon\Carbon::parse('2022-01-02T00:00:00-0600');
    $showNewHours = Carbon\Carbon::now()->gt($newHoursStartAt);
    $currentDate = Carbon\Carbon::now()->format('M d, Y');

    $topStories = $item->loadRelated('top_stories');
    $mostPopularStories = $item->loadRelated('most_popular_stories');
@endphp

<section class="stories" itemscope itemtype="http://schema.org/TouristAttraction">
    <link itemprop="additionalType" href="http://schema.org/Museum" aria-hidden="true"/>
    <link itemprop="additionalType" href="http://schema.org/LandmarksOrHistoricalBuildings" aria-hidden="true"/>
    <link itemprop="additionalType" href="http://schema.org/LocalBusiness" aria-hidden="true"/>
    @component('site.shared._schemaItemProps')
      @slot('itemprops',$itemprops ?? null)
    @endcomponent

    <div class="stories-header" data-behavior="editorialHeader">
        <div id="stories-header__date" class="stories-header__date">
        </div>
        <div class="stories-header__heading">
            <h2 class="stories-header__title">Articles & Videos</h2>
            <p class="stories-header__intro">{{ $intro }}</p>
        </div>
        <div id="stories-header__hours" class="stories-header__hours">
        </div>
    </div>

    <div class="stories-subnav">
        @include('components.molecules._m-auto-subnav', ['subnav' => $subnav])
    </div>

    <div class="stories-fixed_header">
        @if (count($topStories) > 0)
            <div class="stories-top-stories" id="top-stories">
                @foreach ($topStories as $item)
                    @php
                        $isFeatured = $loop->first;
                    @endphp
                    {!! $loop->iteration == 2 ? '<div class="stories-top-stories__side">' : '' !!}
                    {!! $isFeatured ? '<div class="stories-top-stories__featured">' : '' !!}
                    @component('components.molecules._m-listing----stories-listing')
                        @slot('isFeatured', $isFeatured)
                        @slot('item', $item)
                        @slot('fullscreen', false)
                        @slot('titleFont', $isFeatured ? 'f-list-3' : 'f-list-1')
                        @slot('hideImage', $loop->index > 0)
                        @slot('hideDescription', $loop->index > 0)
                        @slot('imageSettings', $imageSettings ?? null)
                    @endcomponent
                    {!! $isFeatured || $loop->last ? '</div>' : '' !!}                
                @endforeach
            </div>
        @endif
        @if (count($mostPopularStories) > 0)
            <div class="stories-most_popular_stories">
                <div class="stories-most_popular_stories__title">
                    <h3>MOST POPULAR</h3>
                </div>
                <ol class="stories-most_popular_stories__list">
                    @foreach ($mostPopularStories as $item)
                        <li>
                            <a class="m-listing__link stories-most_popular_stories__listing" href="{{ method_exists($item, 'getUrl') ? $item->getUrl() : $item->url_without_slug }}">
                                <span class="stories-most_popular_stories__it">{{ $loop->iteration }}</span>
                                <div class="stories-most_popular_stories__meta">
                                    <span class="stories-most_popular_stories__type f-tag">{!! $item->subtype ? $item->present()->subtype : $item->type !!}</span>
                                    @component('components.atoms._title')
                                        @slot('font', $titleFont ?? 'f-list-3')
                                        @slot('title', Str::limit($item->present()->title, 75, $end='...'))
                                        @slot('title_display', $item->present()->title_display)
                                    @endcomponent
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ol>
            </div>
        @endif
    </div>
</section>