<section class="videos" itemscope itemtype="http://schema.org/TouristAttraction">
    <link itemprop="additionalType" href="http://schema.org/Museum" />
    <link itemprop="additionalType" href="http://schema.org/LandmarksOrHistoricalBuildings" />
    <link itemprop="additionalType" href="http://schema.org/LocalBusiness" />

    @component('site.shared._schemaItemProps')
      @slot('itemprops', $itemprops ?? null)
    @endcomponent

    @component('components.molecules._m-header-block')
        {{ $title }}
    @endcomponent
    <p class="f-intro">{{ $intro }}</p>

    <div class="{{$landingPageType}}-subnav">
        @include('components.molecules._m-auto-subnav', ['subnav' => $subnav ?? null])
    </div>

    @php
        $videos = App\Models\Video::where('is_short', true)->take(6)->get();
    @endphp

    <div class="o-grid-block shorts-grid">
        @component('components.molecules._m-title-bar')
            @slot('links', [
                [
                    'label' => 'View all',
                    'href'  => '/videos/shorts',
                    'id' => Str::slug(strip_tags('Art Institute Shorts')),
                ]
            ])
            <span class="o-grid-block__title">Art Institute Shorts</span>
        @endcomponent
        @component('components.organisms._o-grid-listing')
            @slot('behavior', 'dragScroll')
            @slot('cols_xsmall', 1)
            @slot('cols_small', 4)
            @slot('cols_medium', 4)
            @slot('cols_large', 6)
            @slot('cols_xlarge', 6)
            @foreach ($videos as $video)
                @component('components.molecules._m-listing----grid-item')
                    @slot('url', $video->url ?? '')
                    @slot('image', ['src' => $video->thumbnail_url ?? ''])
                    @slot('label', '')
                    @slot('title', $video->title ?? '')
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
            @endforeach
        @endcomponent
    </div>

</section>
