@formField('input', [
    'name' => $titleFormKey ?? 'title',
    'label' => ucfirst($titleFormKey ?? 'title'),
    'translated' => $translateTitle ?? false,
    'required' => true,
    'onChange' => 'formatPermalink'
])

@if ($permalink ?? true)
    @formField('input', [
        'name' => 'slug',
        'label' => 'Permalink',
        'translated' => true,
        'ref' => 'permalink',
        'prefix' => $permalinkPrefix ?? ''
    ])
@endif

@if (!isset($item))
    @formField('select', [
        'name' => 'parent_id',
        'label' => 'Parent Page',
        'options' => $pages,
        'native' => true
    ])
@endif
