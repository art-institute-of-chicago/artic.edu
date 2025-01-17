{{-- Adapted from vendor/a17/laravel-cms-toolkit/views/partials/create.blade.php
  -- Replaces it so that we can provide a hint re: italicizing embedded titles
  -- See `partialView` directive definition in TwillServiceProvider
  --}}
<x-twill::input
    name='{{ $titleFormKey ?? 'title' }}'
    label='{{ $titleFormKey === 'title' ? twillTrans('twill::lang.modal.title-field') : ucfirst($titleFormKey) }}'
    translated='{{ $translateTitle ?? false }}'
    :required='true'
    onChange='formatPermalink'
    note='Avoid HTML in this field. Use the "Title formatting (optional)" field for italics.'
/>

@if ($permalink ?? true)
    <x-twill::input
        name='slug'
        label='twillTrans('twill::lang.modal.permalink-field')'
        translated='true' {{-- WEB-2347 --}}
        ref='permalink'
        prefix='{{$permalinkPrefix ?? ''}}'
    />
@endif
