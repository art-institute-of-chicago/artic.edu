@if( !empty( $items ) )
    @foreach ($items as $date => $item)
        @component('components.molecules._m-date-listing')
            @slot('date', $date)
            @slot('events', $item)
        @endcomponent
    @endforeach
@endif
