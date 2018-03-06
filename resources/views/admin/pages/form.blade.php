@php
    $pageType = App\Models\Page::$types[$item->type];
@endphp

@extends('cms-toolkit::layouts.form', [
    'additionalFieldsets' =>
    $pageType == 'Visit' ? [
        ['fieldset' => 'locations', 'label' => 'Locations'],
        ['fieldset' => 'admissions', 'label' => 'Admissions'],
        ['fieldset' => 'featured_hours', 'label' => 'Featured hours'],
        ['fieldset' => 'dinning_hours', 'label' => 'Dinning hours'],
    ] : []
])

@include('admin.pages.form_' . snake_case($pageType))
