<{{ $tag ?? 'li' }} class="m-date-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
  @component('components.atoms._day')
      @slot('date', $date['date']['date'])
      @slot('month', $date['date']['month'])
      @slot('day', $date['date']['day'])
  @endcomponent
  <ul class="m-date-listing__items">
  @foreach ($date['events'] as $event)
      @component('components.molecules._m-listing----event-row')
          @slot('event', $event)
          @slot('variation', 'm-listing--row')
      @endcomponent
  @endforeach
  </ul>
</{{ $tag ?? 'li' }}>
