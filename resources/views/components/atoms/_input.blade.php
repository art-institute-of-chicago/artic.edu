<span class="input{{ (isset($variation)) ? ' '.$variation : '' }}{{ (isset($error)) ? ' s-error' : '' }}{{ (isset($disabled)) ? ' s-disabled' : '' }}">
    @if ($slot != '')
        @component('components.atoms._label')
            @slot('for', $id)
            @slot('optional', $optional ?? null)
            @slot('hint', $hint ?? null)
            {!! $slot !!}
        @endcomponent
    @endif
    @if (isset($textCount) and $textCount)
    <span class="input__io-container" data-behavior="textCount">
    @endif
    <input class="f-secondary" type="{{ $type ?? 'text'}}" value="{{ $value ?? '' }}" id="{{ $id ?? '' }}" name="{{ $name }}" {{ (isset($placeholder)) ? 'placeholder=' .$placeholder : '' }} {{ (isset($autocomplete)) ? 'autocomplete=' .$autocomplete : '' }} {{ $disabled ?? '' }} {{ (isset($pattern)) ? 'pattern=' .$pattern : '' }} {{ $required ?? '' }}>
    @if (isset($textCount) and $textCount)
    <output for="{{ $id ?? '' }}" class="f-secondary"></output></span>
    @endif
    @if (isset($error))
        @component('components.atoms._error-msg')
            {{ $error ?? '' }}
        @endcomponent
    @endif
</span>
