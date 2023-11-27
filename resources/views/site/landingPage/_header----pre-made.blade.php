<section class="custom-tours-header" itemscope itemtype="http://schema.org/TouristAttraction">
    <link itemprop="additionalType" href="http://schema.org/Museum" aria-hidden="true"/>
    <link itemprop="additionalType" href="http://schema.org/LandmarksOrHistoricalBuildings" aria-hidden="true"/>
    <link itemprop="additionalType" href="http://schema.org/LocalBusiness" aria-hidden="true"/>
    @component('site.shared._schemaItemProps')
        @slot('itemprops',$itemprops ?? null)
    @endcomponent

    @component('components.organisms._o-header-landing')
        @slot('headerMedia', $headerMedia)
    @endcomponent

    @if (!empty($hour))
        @component('components.organisms._o-hours')
            @slot('hour', $hour)
        @endcomponent
    @endif
    <div class="m-title-bar">
        <h2 class="f-display-2">Custom Tours</h2>
    </div>

    <div class="f-deck">
        {!! $header_custom_tours_text !!}
    </div>
    <div class="custom-tours-header__btn-container">
        <a href="{{ $header_custom_tours_primary_button_link }}" class="btn f-buttons">{{ $header_custom_tours_primary_button_label }}</a>
        <a href="{{ $header_custom_tours_secondary_button_link }}" class="btn btn--secondary f-buttons">{{ $header_custom_tours_secondary_button_label }}</a>
    </div>
</section>
