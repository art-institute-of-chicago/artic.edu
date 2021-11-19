@include('admin.partials.create')

@if (!isset($item))
    @formField('select', [
        'name' => 'parent_id',
        'label' => 'Parent Page',
        'options' => $pages,
        'native' => true
    ])
@endif
