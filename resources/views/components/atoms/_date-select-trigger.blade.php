<span class="date-select-trigger {{ $font ?? 'f-link' }}{{ (isset($variation)) ? ' '.$variation : '' }}" data-behavior="selectDate" data-selectDate-mode="range" data-selectDate-displayFormat="friendlyString"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
  <button class="date-select-trigger__open" data-selectDate-open>
    <span class="date-select-trigger__label">{{ $slot }}</span>
    <span class="date-select-trigger__selected-date" data-selectDate-display></span>
  </button>
</span>
