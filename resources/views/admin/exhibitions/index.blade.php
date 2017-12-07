@extends('cms-toolkit::layouts.resources.index', [
    'title' => 'Exhibitions',
    'create' => true,
    'edit' => true,
    'delete' => true,
    'sort' => false,
    'search' => false,
    'publish' => true,
    'toggle_columns' => [
        [
            'toggle_title' => 'Landing page',
            'toggle_field' => 'landing',
            'icon_class'   => 'icon-feature'
        ]
    ],
    'columns' => [
        'title' => [
            'title' => 'Title',
            'edit_link' => true,
            'sort' => true,
            'field' => 'title',
        ],
        'short_copy' => [
            'title' => 'Short Copy',
            'short_copy' => 'Short Copy',
            'edit_link' => true,
            'field' => 'short_copy',
        ]
    ]
])
