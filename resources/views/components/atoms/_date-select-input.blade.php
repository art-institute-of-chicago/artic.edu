<span class="input{{ (isset($variation)) ? ' '.$variation : '' }}{{ (isset($error)) ? ' s-error' : '' }}{{ (isset($disabled)) ? ' s-disabled' : '' }}">
    @if ($slot != '')
        @component('components.atoms._label')
            @slot('for', $id)
            @slot('optional', $optional ?? null)
            @slot('hint', $hint ?? null)
            {!! $slot !!}
        @endcomponent
    @endif
    <span class="input__date-select-container" data-behavior="selectDate" data-selectDate-mode="single" data-selectDate-displayFormat="shortUS">
        <input class="f-secondary" type="{{ $type ?? 'text'}}" value="{{ $value ?? '' }}" id="{{ $id ?? '' }}" name="{{ $name }}" placeholder="{{ $placeholder ?? '' }}" {{ $disabled ?? '' }} data-selectDate-display>
        @component('components.atoms._btn')
            @slot('variation', 'btn--secondary btn--icon-sq')
            @slot('font', '')
            @slot('icon', 'icon--calendar')
            @slot('dataAttributes', 'data-selectDate-open')
            @slot('ariaLabel','Select date or date range')
        @endcomponent
    </span>
    @if (isset($error))
        @component('components.atoms._error-msg')
            {{ $error ?? '' }}
        @endcomponent
    @endif
</span>
