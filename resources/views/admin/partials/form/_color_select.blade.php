@php
    $options = is_object($options) && method_exists($options, 'map') ? $options->map(function($label, $value) {
        return [
            'value' => $value,
            'label' => $label
        ];
    })->values()->toArray() : $options;

    $note = $note ?? false;
    $placeholder = $placeholder ?? false;
    $required = $required ?? false;
    $searchable = $searchable ?? false;
    $disabled = $disabled ?? false;
    $columns = $columns ?? 0;

    // do not use for now, but this will allow you to create a new option directly from the form
    $addNew = $addNew ?? false;
    $moduleName = $moduleName ?? null;
    $storeUrl = $storeUrl ?? '';
    $inModal = $fieldsInModal ?? false;
@endphp

<a17-color-select
    label="{{ $label }}"
    @include('twill::partials.form.utils._field_name')
    :options='{{ json_encode($options) }}'
    :columns="{{ $columns }}"
    @if (isset($default)) selected="{{ $default }}" @endif
    @if ($required) :required="true" @endif
    @if ($inModal) :in-modal="true" @endif
    @if ($disabled) disabled @endif
    @if ($addNew) add-new='{{ $storeUrl }}' @elseif ($note) note='{{ $note }}' @endif
    :has-default-store="true"
    in-store="value"
>
    @if($addNew)
        <div slot="addModal">
            @php
                unset($note, $placeholder, $emptyText, $default, $required, $inModal, $addNew, $options);
            @endphp
            @partialView(($moduleName ?? null), 'create', ['renderForModal' => true, 'fieldsInModal' => true])
        </div>
    @endif
</a17-color-select>

@unless($renderForBlocks || $renderForModal || (!isset($item->$name) && null == $formFieldsValue = getFormFieldsValue($form_fields, $name)))
@push('vuexStore')
    @include('twill::partials.form.utils._selector_input_store')
@endpush
@endunless
