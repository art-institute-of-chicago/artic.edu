<section class="custom" itemscope itemtype="http://schema.org/TouristAttraction">
    <link itemprop="additionalType" href="http://schema.org/Museum" />
    <link itemprop="additionalType" href="http://schema.org/LandmarksOrHistoricalBuildings" />
    <link itemprop="additionalType" href="http://schema.org/LocalBusiness" />
    @component('site.shared._schemaItemProps')
      @slot('itemprops',$itemprops ?? null)
    @endcomponent

    @component('components.molecules._m-header-block')
        {{ $title }}
    @endcomponent

    <div class="{{$landingPageType}}-subnav">
        @include('components.molecules._m-auto-subnav', ['subnav' => $subnav])
    </div>
</section>
