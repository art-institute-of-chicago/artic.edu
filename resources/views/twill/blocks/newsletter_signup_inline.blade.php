@twillBlockTitle('Newsletter signup inline')
@twillBlockIcon('text')

<x-twill::input
    name='copy'
    label='Custom copy'
    note='Override default copy'
    :maxlength='60'
    :translated='true'
/>

@php
    $options = [];

    foreach (\App\Models\ExactTargetList::getList()->toArray() as $value => $label) {
        $options[] = [
            'value' => $value,
            'label' => $label,
        ];
    }
@endphp

<x-twill::select
    name='list'
    label='Newsletter target list'
    :options="$options"
/>
