{{-- Adapted from vendor/a17/laravel-cms-toolkit/views/partials/create.blade.php --}}
{{-- Replaces it so that we can provide a hint re: italicizing embedded titles --}}
{{-- See `partialView` directive definition in TwillServiceProvider --}}
@formField('input', [
    'name' => $titleFormKey ?? 'title',
    'label' => ucfirst($titleFormKey ?? 'title'),
    'translated' => $translateTitle ?? false,
    'required' => true,
    'onChange' => 'formatPermalink',
    'note' => 'Avoid HTML in this field. Use the "Title (HTML)" field for italics.',
])

@if ($permalink ?? true)
    @formField('input', [
        'name' => 'slug',
        'label' => 'Permalink',
        'translated' => true,
        'ref' => 'permalink',
        'prefix' => $permalinkPrefix ?? '',
    ])
@endif
