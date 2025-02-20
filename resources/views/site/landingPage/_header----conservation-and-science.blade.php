<section class="custom" itemscope itemtype="http://schema.org/TouristAttraction">
    <link itemprop="additionalType" href="http://schema.org/Museum" aria-hidden="true"/>
    <link itemprop="additionalType" href="http://schema.org/LandmarksOrHistoricalBuildings" aria-hidden="true"/>
    <link itemprop="additionalType" href="http://schema.org/LocalBusiness" aria-hidden="true"/>
    @component('site.shared._schemaItemProps')
      @slot('itemprops',$itemprops ?? null)
    @endcomponent

    @component('components.molecules._m-header-block')
        {{ $title }}
    @endcomponent

    <div class="o-menu-bar">
        @if(!empty($item->menuItems))
            <ul>
                @foreach($item->menuItems as $item)
                    <li class="m-links-bar__item">
                        <a class="m-links-bar__item-trigger f-link" href={{ $item->link }}>
                            {{ $item->label }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</section>
