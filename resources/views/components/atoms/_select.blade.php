<span class="select{{ (isset($variation)) ? ' '.$variation : '' }}{{ (isset($error)) ? ' s-error' : '' }}{{ (isset($disabled)) ? ' s-disabled' : '' }}">
    @if ($slot != '')
        @component('components.atoms._label')
            @slot('for', $id)
            @slot('optional', $optional ?? null)
            @slot('hint', $hint ?? null)
            {!! $slot !!}
        @endcomponent
    @endif
    <span class="select__select" data-behavior="formSelectFocus">
      <select class="f-secondary" name="{{ $name ?? '' }}" id="{{ $id ?? '' }}" {{ $disabled ?? '' }}>
        @foreach ($options as $option)
            <option {{ ($option['value'] == $value) ? 'selected' : '' }} {!! (isset($option['value'])) ? ' value="'.$option['value'].'"' : '' !!}>{{ $option['label'] ?? '' }}</option>
        @endforeach
      </select>
    </span>
    @if (isset($error))
        @component('components.atoms._error-msg')
            {{ $error ?? '' }}
        @endcomponent
    @endif
</span>
