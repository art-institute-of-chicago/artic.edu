<div class="o-hours f-secondary">
    <div class="o-hours__clock">
        <svg class="icon--clock" aria-hidden="true">
            <use xlink:href="#icon--clock"></use>
        </svg>
    </div>
    <div class="o-hours__text">
        <span class="o-hours__status o-hours__status--mobile">{{
            $hour->present()->getStatusHeader(null, true)
        }}</span>
        <span class="o-hours__status o-hours__status--desktop">{{
            $hour->present()->getStatusHeader()
        }}</span>
        @if ($hoursHeader = $hour->present()->getHoursHeader())
            <span class="o-hours__hours">{{ $hoursHeader }}</span>
        @endif
        @component('components.atoms._dropdown')
            @slot('variation', 'dropdown--filter')
            @slot('prompt', 'See all hours')
            @slot('ariaTitle', 'See all hours')
            @foreach ($hour->present()->getHoursTableForHeader() as $item)
                <li class="o-hours__item o-hours__item--hours">
                    <span class="o-hours__item__days">{{ $item['days'] }}</span>
                    <span class="o-hours__item__hours">{{ $item['hours'] }}</span>
                </li>
            @endforeach
            @if (!empty($hour->additional_text))
                <li class="o-hours__item">
                    {{ $hour->additional_text }}
                </li>
            @endif
        @endcomponent
    </div>
</div>
