@extends('cms-toolkit::layouts.resources.index', [
    'create' => true,
    'edit' => true,
    'delete' => true,
    'sort' => false,
    'search' => true,
    'publish' => true,
    'columns' => [
        'image' => [
            'title' => 'Hero',
            'thumb' => true,
            'variant' => [
                'role' => 'hero',
                'crop' => 'square',
            ],
        ],
        'title' => [
            'title' => 'Title',
            'edit_link' => true,
            'sort' => true,
            'field' => 'title',
        ],
        'artworksCount' => [
            'title' => 'Artworks count',
            'edit_link' => true,
            'field' => 'artworksCount',
            'present' => true
        ]
    ]
])


