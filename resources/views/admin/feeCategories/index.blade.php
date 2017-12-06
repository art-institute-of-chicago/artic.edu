@extends('cms-toolkit::layouts.resources.index', [
    'title' => 'Admission Categories',
    'create' => true,
    'edit' => true,
    'delete' => true,
    'sort' => true,
    'search' => false,
    'publish' => false,
    'columns' => [
        'title' => [
            'title' => 'Field title',
            'edit_link' => true,
            'sort' => false,
            'field' => 'title',
        ]
    ]
])

{{-- Remove buttons when there're 5 or more Categories  --}}
@if (count($items) >= 5)
    @section('footer')
    @stop
@endif
