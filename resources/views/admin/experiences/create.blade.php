@formField('input', [
    'name' => 'title',
    'label' => 'Title',
    'translated' => $translateTitle ?? false,
    'required' => true,
    'onChange' => 'formatPermalink',
])

@formField('select', [
    'name' => 'interactive_feature_id',
    'label' => 'Grouping',
    'placeholder' => 'Select an grouping',
    'options' => $groupingsList,
])

@if ($permalink ?? true)
    @formField('input', [
        'name' => 'slug',
        'label' => 'Permalink',
        'translated' => true, # WEB-2347
        'ref' => 'permalink',
        'prefix' => $permalinkPrefix ?? ''
    ])
@endif
