@extends('cms-toolkit::layouts.resources.index', [
    'title' => 'Events',
    'create' => true,
    'edit' => true,
    'delete' => true,
    'sort' => false,
    'search' => false,
    'publish' => true,
    'columns' => [
        'title' => [
            'title' => 'Title',
            'edit_link' => true,
            'sort' => true,
            'field' => 'title',
        ]
    ]
])
