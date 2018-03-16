@php
    $pageType = App\Models\Page::$types[$item->type];
@endphp

@extends('cms-toolkit::layouts.form', [
    'additionalFieldsets' => $additionalFieldsets
])

@include('admin.pages.form_' . snake_case($pageType))

@push('vuexStore')
  window.STORE.publication.submitOptions = {
    update: [
      {
        name: 'update',
        text: 'Update'
      },
      {
        name: 'cancel',
        text: 'Cancel'
      }
    ]
  }
@endpush
