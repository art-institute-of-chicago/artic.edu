{{-- This file copied from vendor/area17/twill/views/partials/form/_checkbox.blade.php
  -- To add a note display to checkboxes.
  --}}
@php
    $note = $note ?? false;
    $default = $default ?? false;
    $inModal = $fieldsInModal ?? false;
    $disabled = $disabled ?? false;
    $confirmMessageText = $confirmMessageText ?? '';
    $confirmTitleText = $confirmTitleText ?? '';
    $requireConfirmation = $requireConfirmation ?? false;
@endphp

<a17-singlecheckbox
    @include('twill::partials.form.utils._field_name')
    label="{{ $label ?? '' }}"
    :initial-value="{{ $default ? 'true' : 'false' }}"
    @if ($note) note='{{ $note }}' @endif
    @if ($disabled) disabled @endif
    @if ($requireConfirmation) :require-confirmation="true" @endif
    @if ($confirmMessageText) confirm-message-text="{{ $confirmMessageText }}"  @endif
    @if ($confirmTitleText) confirm-title-text="{{ $confirmTitleText }}"  @endif
    :has-default-store="true"
    in-store="currentValue"
></a17-singlecheckbox>

{{-- Begin section that was added --}}
@if ($note) <span class="input__note f--small" style="color: #8c8c8c;">{{ $note }}</span> @endif
{{-- End section that was added --}}

@unless($renderForBlocks || $renderForModal || (!isset($item->$name) && null == $formFieldsValue = getFormFieldsValue($form_fields, $name)))
@push('vuexStore')
    window['{{ config('twill.js_namespace') }}'].STORE.form.fields.push({
        name: '{{ $name }}',
        value: @if(isset($item) && $item->$name || ($formFieldsValue ?? false)) true @else false @endif
    })
@endpush
@endunless
