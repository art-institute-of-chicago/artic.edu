<{{ $tag ?? 'li' }} class="m-date-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
    @component('components.atoms._day')
      @slot('date', printDate($date))
      @slot('month', printMonth($date))
      @slot('day', printDay($date))
    @endcomponent
    <div class="m-date-listing__listings">
      <ul class="m-date-listing__items">
      @foreach ($events as $item)
          @component('components.molecules._m-listing----event-row')
              @slot('item', $item)
              @slot('variation', 'm-listing--row')
              @slot('imageSettings', $imageSettings ?? null)
              @slot('gtmAttributes', 'data-gtm-event="' . $item->title . '" data-gtm-event-action="' . ($exhibitionTitle ?? $seo->title) . '" data-gtm-event-category="nav-link"')
          @endcomponent
      @endforeach
      </ul>

        @if (isset($ongoing) && !$ongoing->isEmpty())
            <h4 class="m-date-listing__listings-title f-module-title-1">Ongoing events</h4>
            <ul class="m-date-listing__items">
            @foreach ($ongoing as $item)
                @component('components.molecules._m-listing----event-row')
                    @slot('item', $item)
                    @slot('titleFont', 'f-list-2')
                    @slot('hideShortDesc', true)
                    @slot('variation', 'm-listing--row m-listing--secondary')
                    @slot('imageSettings', $imageSettingsOnGoing ?? null)
                    @slot('gtmAttributes', 'data-gtm-event="' . $item->title . '" data-gtm-event-action="' . ($exhibitionTitle ?? $seo->title) . '" data-gtm-event-category="nav-link"')
                @endcomponent
            @endforeach
            </ul>
        @endif
    </div>
</{{ $tag ?? 'li' }}>
