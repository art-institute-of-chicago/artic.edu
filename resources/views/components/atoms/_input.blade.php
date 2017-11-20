<span class="input{{ (isset($variation)) ? ' '.$variation : '' }}{{ (isset($error)) ? ' s-error' : '' }}{{ (isset($disabled)) ? ' s-disabled' : '' }}">
    @if ($slot != '')
        @component('components.atoms._label')
            @slot('for', $id)
            {{ $slot }}
        @endcomponent
    @endif
    @if (isset($textCount))
    <span class="input-with-output" data-behavior="textCount">
    @endif
    <input class="f-secondary" type="{{ $type ?? 'text'}}" value="{{ $value ?? '' }}" id="{{ $id ?? '' }}" name="{{ $name }}" placeholder="{{ $placeholder ?? '' }}" {{ $disabled ?? '' }}>
    @if (isset($textCount))
    <output for="{{ $id ?? '' }}" class="f-secondary"></output></span>
    @endif
    @if (isset($error))
        @component('components.atoms._error-msg')
            {{ $error ?? '' }}
        @endcomponent
    @endif
</span>
