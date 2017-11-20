<span class="radio{{ (isset($variation)) ? ' '.$variation : '' }}{{ (isset($error)) ? ' s-error' : '' }}{{ (isset($disabled)) ? ' s-disabled' : '' }}">
  <input type="radio" value="{{ $value ?? '' }}" id="{{ $id ?? '' }}" name="{{ $name ?? '' }}" {{ $checked ?? '' }} {{ $disabled ?? '' }}>
  @component('components.atoms._label')
    @slot('for', $id)
    {{ $label ?? '' }}
  @endcomponent
  @if (isset($error))
      @component('components.atoms._error-msg')
          {{ $error ?? '' }}
      @endcomponent
  @endif
</span>
