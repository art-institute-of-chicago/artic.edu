{{-- This file copied from vendor/area17/twill/views/partials/form/_checkbox.blade.php --}}
{{-- To add a note display to checkboxes. --}}
@php
    $note = $note ?? false;
    $inline = $inline ?? false;
    $default = $default ?? false;
    $inModal = $fieldsInModal ?? false;
@endphp

<a17-singlecheckbox
    @include('twill::partials.form.utils._field_name')
    label="{{ $label ?? '' }}"
    :initial-value="{{ $default ? 'true' : 'false' }}"
    @if ($note) note='{{ $note }}' @endif
    :has-default-store="true"
    in-store="currentValue"
></a17-singlecheckbox>

{{-- Begin section that was added --}}
@if ($note) <span class="input__note f--small" style="color: #8c8c8c;">{{ $note }}</span> @endif
{{-- End section that was added --}}

@unless($renderForBlocks || $renderForModal || (!isset($item->$name) && null == $formFieldsValue = getFormFieldsValue($form_fields, $name)))
@push('vuexStore')
    window.STORE.form.fields.push({
        name: '{{ $name }}',
        value: @if(isset($item) && $item->$name || ($formFieldsValue ?? false)) true @else false @endif
    })
@endpush
@endunless
