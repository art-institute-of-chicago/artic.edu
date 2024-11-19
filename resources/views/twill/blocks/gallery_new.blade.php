@php
    $currentUrl = explode('/', request()->url());
    $type = $currentUrl[5] ?? null;
@endphp

@twillBlockTitle('Gallery')
@twillBlockIcon('image')

{{-- WEB-1251: Inline contents partial for shared gallery block --}}
@include('twill.partials.gallery-shared')

@if ($type === 'digitalPublications')
    @formField('checkbox', [
        'name' => 'hide_figure_number',
        'label' => 'Hide figure number',
        'default' => false,
    ])
@endif

@formField('wysiwyg', [
    'name' => 'title',
    'label' => 'Title',
    'maxlength' => 60,
    'toolbarOptions' => [
        'italic', 'link',
    ],
])

@formField('wysiwyg', [
    'name' => 'description',
    'label' => 'Description',
    'rows' => 4,
    'maxlength' => 500,
    'note' => 'Will be hidden if title is empty',
    'toolbarOptions' => [
        'italic', 'link',
    ],
])

@formField('checkbox', [
    'name' => 'disable_gallery_modals',
    'label' => 'Disable modals for this gallery',
])

@formField('checkbox', [
    'name' => 'is_gallery_zoomable',
    'label' => 'Make all image modals zoomable (override)',
])

@formField('repeater', [
    'type' => 'gallery_new_item',
])
