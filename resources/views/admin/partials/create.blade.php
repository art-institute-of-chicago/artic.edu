{{-- Adapted from vendor/a17/laravel-cms-toolkit/views/partials/create.blade.php --}}
{{-- Replaces it so title is wysiwyg w/ italics --}}
{{-- See `partialView` directive definition in TwillServiceProvider --}}
@formField('wysiwyg', [
    'name' => $titleFormKey ?? 'title',
    'label' => ucfirst($titleFormKey ?? 'title'),
    'translated' => $translateTitle ?? false,
    'required' => true,
    'onChange' => 'formatPermalink',
    'toolbarOptions' => [
        'italic',
    ],
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
