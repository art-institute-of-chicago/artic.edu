<section class="my-museum-tour-header" itemscope itemtype="http://schema.org/TouristAttraction">
    <link itemprop="additionalType" href="http://schema.org/Museum" aria-hidden="true"/>
    <link itemprop="additionalType" href="http://schema.org/LandmarksOrHistoricalBuildings" aria-hidden="true"/>
    <link itemprop="additionalType" href="http://schema.org/LocalBusiness" aria-hidden="true"/>
    @component('site.shared._schemaItemProps')
        @slot('itemprops',$itemprops ?? null)
    @endcomponent

    @component('components.organisms._o-header-landing')
        @slot('headerMedia', $headerMedia)
        @slot('variation', 'my-museum-tour')
    @endcomponent

    @if (!empty($hour))
        @component('components.organisms._o-hours')
            @slot('hour', $hour)
        @endcomponent
    @endif
    <div class="m-title-bar">
        <h1 class="f-display-2">My Museum Tour</h1>
    </div>

    @if ($header_my_museum_tour_text)
        <div class="f-deck">
            {!! $header_my_museum_tour_text !!}
        </div>
    @endif

    <div class="my-muusem-tour-header__btn-container">
        @if ($header_my_museum_tour_primary_button_link && $header_my_museum_tour_primary_button_label)
            <a href="{{ $header_my_museum_tour_primary_button_link }}" class="btn f-buttons">{{ $header_my_museum_tour_primary_button_label }}</a>
        @endif
        <a href="#aic-ct-landingpage" class="btn btn--secondary f-buttons">{{ $header_my_museum_tour_secondary_button_label ? $header_my_museum_tour_secondary_button_label : 'Explore tours' }}</a>
    </div>

</section>
