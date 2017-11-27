<{{ $tag ?? 'h3' }} class="day{{ (isset($variation)) ? ' '.$variation : '' }}">
    <span class="day__date f-numeral-date">{{ $date }}</span>
    <span class="day__month f-tag">{{ $month }}</span>
    <span class="day__day f-tag">{{ $day }}</span>
</{{ $tag ?? 'h3' }}>
