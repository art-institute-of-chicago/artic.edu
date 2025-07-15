<span class="checkbox{{ (isset($variation)) ? ' '.$variation : '' }}{{ (isset($error)) ? ' s-error' : '' }}{{ (isset($disabled)) ? ' s-disabled' : '' }}"{!! (isset($behavior)) ? ' data-behavior="'.$behavior.'"' : '' !!} {!! isset($attribute) ? $attribute : '' !!}>
  <input type="checkbox" value="{{ $value ?? '' }}" id="{{ $id ?? '' }}" name="{{ $name ?? '' }}" {{ $checked ?? '' }} {{ $disabled ?? '' }} {!! ($autocomplete ?? true) ? '' : 'autocomplete="off"' !!}>
  <span class="{{ $font ?? 'f-secondary' }}">
      @component('components.atoms._label')
        @slot('for', $id)
        @slot('font', '')
        @slot('optional', $optional ?? null)
        @slot('hint', $hint ?? null)
        {!! $label ?? '' !!}
      @endcomponent
  </span>
  @if (isset($error))
      @component('components.atoms._error-msg')
          {{ $error ?? '' }}
      @endcomponent
  @endif
</span>
