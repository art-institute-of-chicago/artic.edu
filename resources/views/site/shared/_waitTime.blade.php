@if ($waitTime)
    @component('components.organisms._o-wait-time')
        @slot('waitTime', $waitTime)
    @endcomponent
@endif
