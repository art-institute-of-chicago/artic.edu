@extends('cms-toolkit::layouts.resources.index', [
    'title' => 'Admission Fees - Categories',
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
