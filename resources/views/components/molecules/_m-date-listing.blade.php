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
          @endcomponent
      @endforeach
      </ul>
      <h4 class="m-date-listing__listings-title f-module-title-1">Ongoing events</h4>
      <ul class="m-date-listing__items">
        @if (isset($date['ongoingEvents']))
          @foreach ($date['ongoingEvents'] as $item)
              @component('components.molecules._m-listing----event-row')
                  @slot('item', $item)
                  @slot('titleFont', 'f-list-2')
                  @slot('hideShortDesc', true)
                  @slot('variation', 'm-listing--row m-listing--secondary')
              @endcomponent
          @endforeach
        @endif
      </ul>
    </div>
</{{ $tag ?? 'li' }}>
