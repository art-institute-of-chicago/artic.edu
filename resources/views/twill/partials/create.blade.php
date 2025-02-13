{{-- Adapted from vendor/a17/laravel-cms-toolkit/views/partials/create.blade.php
  -- Replaces it so that we can provide a hint re: italicizing embedded titles
  -- See `partialView` directive definition in TwillServiceProvider
  --}}
@php
  $titleFormKey = $titleFormKey ?? 'title';
  $titleFormLabel = $titleFormLabel ?? 'Title';
@endphp
<x-twill::input
  :name="$titleFormKey"
  :label="$titleFormKey === 'title' && $titleFormLabel === 'Title' ? twillTrans('twill::lang.modal.title-field') : $titleFormLabel"
  {{-- Added --}}
  note='Avoid HTML in this field. Use the "Title formatting (optional)" field for italics.'
  {{-- /Added --}}
  :translated="$translateTitle ?? false"
  :required="true"
  on-change="formatPermalink"
/>

@if ($permalink ?? true)
  <x-twill::input
      name="slug"
      :label="twillTrans('twill::lang.modal.permalink-field')"
      :translated="true"
      ref="permalink"
      :prefix="$permalinkPrefix ?? ''"
  />
@endif
