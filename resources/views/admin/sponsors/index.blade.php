@extends('cms-toolkit::layouts.resources.index', [
    'create' => true,
    'edit' => true,
    'delete' => true,
    'sort' => false,
    'search' => true,
    'publish' => true,
    'columns' => [
        'title' => [
            'title' => 'Title',
            'edit_link' => true,
            'sort' => true,
            'field' => 'title',
        ],
        'copy' => [
            'title' => 'Sponsor Copy',
            'copy' => 'Sponsor Copy',
            'edit_link' => true,
            'field' => 'copy',
        ]
    ]
])
