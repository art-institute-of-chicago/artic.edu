<label for="{{ $for ?? '' }}" class="label {{ (isset($error)) ? ' s-error' : '' }} {{ $font ?? 'f-secondary' }}{{ (isset($variation)) ? ' '.$variation : '' }}">
    {!! $slot ?? '' !!}
    @if (isset($optional) and $optional)
        &nbsp;<em class="label__optional">(optional)</em>
    @endif
    @if (isset($hint) and $hint)
        <em class="label__hint">{!! $hint !!}</em>
    @endif
    @if (isset($error))
        @component('components.atoms._error-msg')
            {{ $error ?? '' }}
        @endcomponent
    @endif
</label>
