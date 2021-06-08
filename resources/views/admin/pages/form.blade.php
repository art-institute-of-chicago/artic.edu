@php
    $pageType = App\Models\Page::$types[$item->type];
@endphp

@extends('twill::layouts.form', [
    'additionalFieldsets' => $additionalFieldsets
])

@include('admin.pages.form_' . Str::snake($pageType))

@push('vuexStore')
  window[process.env.VUE_APP_NAME].STORE.publication.submitOptions = {
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
