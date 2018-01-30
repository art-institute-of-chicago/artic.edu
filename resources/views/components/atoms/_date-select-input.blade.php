<span class="input input--date-select{{ (isset($variation)) ? ' '.$variation : '' }}{{ (isset($error)) ? ' s-error' : '' }}{{ (isset($disabled)) ? ' s-disabled' : '' }}">
    @if ($slot != '')
        @component('components.atoms._label')
            @slot('for', $id)
            @slot('optional', $optional ?? null)
            @slot('hint', $hint ?? null)
            {!! $slot !!}
        @endcomponent
    @endif
    <input class="f-secondary" type="{{ $type ?? 'text'}}" value="{{ $value ?? '' }}" id="{{ $id ?? '' }}" name="{{ $name }}" placeholder="{{ $placeholder ?? '' }}" {{ $disabled ?? '' }}>

    @component('components.atoms._date-select-trigger')
        Select Date
    @endcomponent

    @if (isset($error))
        @component('components.atoms._error-msg')
            {{ $error ?? '' }}
        @endcomponent
    @endif
</span>
