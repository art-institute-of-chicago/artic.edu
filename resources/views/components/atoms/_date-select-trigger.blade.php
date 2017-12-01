@if (isset($range) and $range)
<span class="date-select-trigger {{ $font ?? 'f-buttons' }}{{ (isset($variation)) ? ' '.$variation : '' }}" data-behavior="selectDate" data-selectDate-range="true" data-selectDate-id="{{ $selectDateId ?? '' }}" data-selectDate-role="{{ $selectDateRole ?? '' }}" data-selectDate-linkedId="{{ $selectDateLinkedId ?? '' }}">
@else
<span class="date-select-trigger {{ $font ?? 'f-buttons' }}{{ (isset($variation)) ? ' '.$variation : '' }}" data-behavior="selectDate">
@endif
  <button class="date-select-trigger__open" data-selectDate-open>
    <svg class="icon--calendar"><use xlink:href="#icon--calendar" /></svg>
    <span class="date-select-trigger__label">{{ $slot }}</span>
    <span class="date-select-trigger__selected-date" data-selectDate-display></span>
  </button>
  <button class="date-select-trigger__clear" data-selectDate-clear><svg class="icon--close-circle"><use xlink:href="#icon--close-circle" /></svg></button>
  @if (isset($hiddenInputName) || isset($hiddenInputId))
  <input type="hidden" name="{{ $hiddenInputName ?? '' }}" id="{{ $hiddenInputId ?? '' }}" value="{{ $hiddenInputValue ?? '' }}">
  @endif
</span>
