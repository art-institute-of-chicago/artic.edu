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
        <p>
            Build a museum tour customized with artworks you love. Create a tour for yourself, make one to share with friends and family, or explore tours that we have created—it's an easy way to make an unforgettable museum visit.
        </p>
    </div>
    <div class="custom-tours-header__btn-container">
        <a href="#" class="btn f-buttons">Create your own</a>
        <a href="#" class="btn btn--secondary f-buttons">Explore tours</a>
    </div>
</section>
