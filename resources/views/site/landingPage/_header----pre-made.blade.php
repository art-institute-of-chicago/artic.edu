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

{{--    @component('components.molecules._m-media')--}}
{{--        @slot('item', $headerMedia)--}}
{{--        @slot('tag', 'span')--}}
{{--        @slot('imageSettings', array(--}}
{{--            'srcset' => array(300,600,1000,1500,3000),--}}
{{--            'sizes' => '100vw',--}}
{{--        ))--}}
{{--        @slot('variation', 'm-visit-header')--}}
{{--    @endcomponent--}}

    @if (!empty($hour))
        @component('components.organisms._o-hours')
            @slot('hour', $hour)
        @endcomponent
    @endif
    <h2 class="f-headline">Custom Tours</h2>
    <div>
{{--        {{ $header_custom_tours_text }}--}}
        <p>
            Build a museum tour customized with artworks you love. Create a tour for yourself, make one to share with friends and family, or explore tours that we have created—it's an easy way to make an unforgettable museum visit.
        </p>
    </div>
    <div>
        <a href="#" class="btn f-buttons">Create your own</a>
        <a href="#" class="btn btn--secondary f-buttons">Explore tours</a>
    </div>
</section>
