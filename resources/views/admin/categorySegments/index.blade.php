@extends('cms-toolkit::layouts.resources.index', [
    'title' => 'Category Segment',
    'create' => true,
    'edit' => true,
    'delete' => true,
    'search' => true,
    'columns' => [
        'title' => [
            'title' => 'Title',
            'edit_link' => true,
            'field' => 'title',
        ]
    ]
])


