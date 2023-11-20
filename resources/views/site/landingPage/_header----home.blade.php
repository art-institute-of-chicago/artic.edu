@php
    $newHoursStartAt = Carbon\Carbon::parse('2022-01-02T00:00:00-0600');
    $showNewHours = Carbon\Carbon::now()->gt($newHoursStartAt);
@endphp

<section class="home" itemscope itemtype="http://schema.org/TouristAttraction">

    <link itemprop="additionalType" href="http://schema.org/Museum" aria-hidden="true"/>
    <link itemprop="additionalType" href="http://schema.org/LandmarksOrHistoricalBuildings" aria-hidden="true"/>
    <link itemprop="additionalType" href="http://schema.org/LocalBusiness" aria-hidden="true"/>
    @component('site.shared._schemaItemProps')
      @slot('itemprops',$itemprops ?? null)
    @endcomponent
    
    @component('components.organisms._o-header-landing')
        @slot('mainFeatures', $mainFeatures)
        @slot('headerMedia', $headerMedia)
        @slot('variation', 'home')
    @endcomponent

    @if (!empty($hour))
        @component('components.organisms._o-hours')
            @slot('hour', $hour)
        @endcomponent
    @endif

    <div class="home-top">
        <div class="home-callout">
            <span class="title f-headline-editorial home-callout-text">{!! $item->home_intro !!}</span>
        </div>
        @if($item->home_location_link || $item->home_location_label || $item->home_buy_tix_link || $item->home_buy_tix_label)
            <div class="home-top-info">
                @if ($item->home_location_link || $item->home_location_label)
                    <div>
                        <span class="home-location">
                            <svg><use xlink:href="#icon--location"/></svg>
                            <a href="{{ $item->home_location_link }}">{{ $item->home_location_label }}</a>
                        </span>
                    </div>
                @endif
                @if ($item->home_buy_tix_link || $item->home_buy_tix_label)
                    <div>
                        <span class="home-ticket">
                            <svg><use xlink:href="#icon--ticket"/></svg>
                            <a href="{{ $item->home_buy_tix_link }}">{{ $item->home_buy_tix_label }}</a>
                        </span>
                    </div>
                @endif
                @if (!empty($socialLinks))
                    <div>
                        <span class="f-module-title-1">FOLLOW US</span>
                        <div>
                            @foreach ($socialLinks as $link)
                                <a href="{{$link->link}}">
                                    <svg><use xlink:href="#icon--{{ImageHelpers::getSocialIcon($link['link'])}}"/></svg>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>

</section>