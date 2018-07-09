{{-- Adapted from vendor/a17/laravel-cms-toolkit/views/partials/create.blade.php --}}
{{-- Replaces it so that we can provide a hint re: italicizing embedded titles --}}
{{-- See `partialView` directive definition in TwillServiceProvider --}}
@formField('input', [
    'name' => $titleFormKey ?? 'title',
    'label' => ucfirst($titleFormKey ?? 'title'),
    'translated' => $translateTitle ?? false,
    'required' => true,
    'onChange' => 'formatPermalink',
    'note' => 'Use <i></i> to italicize titles within the title'
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
