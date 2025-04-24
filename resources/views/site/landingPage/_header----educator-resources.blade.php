<section class="educator-resources" itemscope itemtype="http://schema.org/TouristAttraction">
    <link itemprop="additionalType" href="http://schema.org/Museum" aria-hidden="true"/>
    <link itemprop="additionalType" href="http://schema.org/LandmarksOrHistoricalBuildings" aria-hidden="true"/>
    <link itemprop="additionalType" href="http://schema.org/LocalBusiness" aria-hidden="true"/>
    @component('site.shared._schemaItemProps')
      @slot('itemprops',$itemprops ?? null)
    @endcomponent

    @component('components.organisms._o-header-landing')
        @slot('headerMedia', $headerMedia)
        @slot('variation', 'educator-resources')
    @endcomponent

  <div class="educator-resources-top">
    @if ($item->labels->get('header_search_title') || $item->labels->get('header_search_description') || $item->labels->get('header_search_button_label') || $item->labels->get('header_search_button_link'))
      <div class="educator-resources-top__callout">
          {!! $item->labels->get('header_search_title') ? '<h2>'. $item->labels->get('header_search_title') .'</h2>' : '' !!}
          {!! $item->labels->get('header_search_description') ? '<p>'. $item->labels->get('header_search_description') .'</p>' : '' !!}
          {!! ($item->labels->get('header_search_button_label') && $item->labels->get('header_search_button_link')) ? '<span><a href="'. $item->labels->get('header_search_button_link') .'">'. $item->labels->get('header_search_button_label') .'</a>' : '' !!}
          <svg class="icon--arrow"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow--24"></use></svg></a></span>
      </div>
    @endif
      <div class="educator-resources-top__quick-search">
        <h3>Content</h3>
        @component('components.atoms._dropdown')
          @slot('prompt', 'Select')
          @slot('ariaTitle', 'Content dropdown selector')
          @slot('variation','dropdown educator-resources__dropdown')
          @slot('font', null)
          @slot('options', $contentSortOptions)
          @slot('behavior', 'dynamicFilterDropdown')
          @slot('attribute', 'data-filter-behavior="content"')
        @endcomponent

        <h3>Audience</h3>
        @component('components.atoms._dropdown')
          @slot('prompt', 'Select')
          @slot('ariaTitle', 'Audience dropdown selector')
          @slot('variation','dropdown educator-resources__dropdown')
          @slot('font', null)
          @slot('options', $audienceSortOptions)
          @slot('behavior', 'dynamicFilterDropdown')
          @slot('attribute', 'data-filter-behavior="audience"')
        @endcomponent

        <a data-behavior="dynamicFilterSearchBuilder" href="" ><button class="btn f-buttons btn--primary">Search</button></a>
      </div>
  </div>

</section>