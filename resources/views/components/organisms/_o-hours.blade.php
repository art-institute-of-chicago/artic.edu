<div class="o-hours f-secondary">
    <div class="o-hours__clock">
        <svg class="icon--clock" aria-hidden="true">
            <use xlink:href="#icon--clock"></use>
        </svg>
    </div>
    <div class="o-hours__text">
        <span class="o-hours__text__status">{{ $hour->present()->getStatusHeader() }}</span>
        @if ($hoursHeader = $hour->present()->getHoursHeader())
            <span class="o-hours__text__hours">{{ $hoursHeader }}</span>
        @endif
        @component('components.atoms._dropdown')
            @slot('variation', 'dropdown--filter')
            @slot('prompt', 'See all hours')
            @slot('ariaTitle', 'See all hours')
            <li>Lorem ipsum</li>
        @endcomponent
    </div>
</div>
