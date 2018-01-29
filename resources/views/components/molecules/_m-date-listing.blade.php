<{{ $tag ?? 'li' }} class="m-date-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
    @component('components.atoms._day')
      @slot('date', $date['date']['date'])
      @slot('month', $date['date']['month'])
      @slot('day', $date['date']['day'])
    @endcomponent
    <div class="m-date-listing__listings">
      <ul class="m-date-listing__items">
      @foreach ($date['events'] as $item)
          @component('components.molecules._m-listing----event-row')
              @slot('item', $item)
              @slot('variation', 'm-listing--row')
          @endcomponent
      @endforeach
      </ul>
      <h4 class="m-date-listing__listings-title f-module-title-1">Ongoing events</h4>
      <ul class="m-date-listing__items">
      @foreach ($date['ongoingEvents'] as $item)
          @component('components.molecules._m-listing----event-row')
              @slot('item', $item)
              @slot('titleFont', 'f-list-2')
              @slot('hideShortDesc', true)
              @slot('variation', 'm-listing--row m-listing--secondary')
          @endcomponent
      @endforeach
      </ul>
    </div>
</{{ $tag ?? 'li' }}>
