@php
    $includeDefault = $includeDefault ?? true;
    $types = $types ?? [];
    $field = $field ?? 'theme';
    $label = $label ?? str($field)->ucfirst();
    if (!isset($options)) {
        $options = collect([$includeDefault ? 'default' : null])->concat($types)->filter()->map(function($type) {
            return [
                'value' => str($type)->slug(),
                'label' => str($type)->ucfirst(),
            ];
        })->toArray();
    }
@endphp
<x-twill::select
    :name="$field"
    :label="$label"
    default='default'
    :options="$options"
/>
