<label for="{{ $for ?? '' }}" class="label {{ $font ?? 'f-secondary' }}{{ (isset($variation)) ? ' '.$variation : '' }}">
    {!! $slot ?? '' !!}
    @if (isset($optional) and $optional)
        &nbsp;<em class="label__optional">(optional)</em>
    @endif
    @if (isset($hint) and $hint)
        <em class="label__hint">{!! $hint !!}</em>
    @endif
</label>
