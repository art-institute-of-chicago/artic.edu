<span class="input{{ (isset($variation)) ? ' '.$variation : '' }}{{ (isset($error)) ? ' s-error' : '' }}{{ (isset($disabled)) ? ' s-disabled' : '' }}">
    @if ($slot != '')
        @component('components.atoms._label')
            @slot('for', $id)
            @slot('optional', $optional ?? null)
            @slot('hint', $hint ?? null)
            {!! $slot !!}
        @endcomponent
    @endif
    <div class="g-recaptcha" data-sitekey="{{ config('forms.recaptcha_key') }}" data-behavior="recaptcha" id="g-recaptcha"></div>
    @if (isset($error))
        @component('components.atoms._error-msg')
            {{ $error ?? '' }}
        @endcomponent
    @endif
</span>
