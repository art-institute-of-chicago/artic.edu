<section class="my-museum-tour-header" itemscope itemtype="http://schema.org/TouristAttraction">
    <link itemprop="additionalType" href="http://schema.org/Museum" aria-hidden="true"/>
    <link itemprop="additionalType" href="http://schema.org/LandmarksOrHistoricalBuildings" aria-hidden="true"/>
    <link itemprop="additionalType" href="http://schema.org/LocalBusiness" aria-hidden="true"/>
    @component('site.shared._schemaItemProps')
        @slot('itemprops',$itemprops ?? null)
    @endcomponent

    @if (!$headerMedia['style'] == 'my_museum_tour')
        @component('components.organisms._o-header-landing')
            @slot('mainFeatures', $mainFeatures)
            @slot('headerMedia', $headerMedia)
            @slot('variation', 'my-museum-tour')
        @endcomponent
    @else
        @component('components.organisms._o-my-museum-tours-landing-header')
            @slot('header_my_museum_tour_header_image', $header_my_museum_tour_header_image)
            @slot('header_my_museum_tour_text', $header_my_museum_tour_text)
            @slot('header_my_museum_tour_primary_button_link', $header_my_museum_tour_primary_button_link)
            @slot('header_my_museum_tour_primary_button_label', $header_my_museum_tour_primary_button_label)
            @slot('header_my_museum_tour_secondary_button_link', $header_my_museum_tour_primary_button_link)
            @slot('header_my_museum_tour_secondary_button_label', $header_my_museum_tour_secondary_button_label)
            @slot('header_my_museum_tour_icons', $header_my_museum_tour_icons)
    @component('components.organisms._o-header-landing')
        @slot('headerMedia', $headerMedia)
        @slot('variation', 'my-museum-tour')
    @endcomponent

    @if (!empty($hour))
        @component('components.organisms._o-hours')
            @slot('hour', $hour)
        @endcomponent
    @endif
</section>
