@formField('input', [
    'name' => $titleFormKey ?? 'title',
    'label' => ucfirst($titleFormKey ?? 'title'),
    'translated' => $translateTitle ?? false,
    'required' => true,
])

@if (!isset($item))
    @formField('input', [
        'name' => 'destination',
        'label' => 'Destination',
        'required' => true,
    ])
@endif
