@extends('cms-toolkit::layouts.resources.index', [
    'title' => "Closures",
    'create' => true,
    'edit' => true,
    'delete' => false,
    'sort' => false,
    'search' => false,
    'publish' => true,
    'columns' => [
        'type' => [
            'title' => 'Type',
            'present' => true,
            'field' => 'presentType',
            'edit_link' => true,
        ],
        'opening_time' => [
            'title' => 'Start Date',
            'present' => true,
            'field' => 'presentStartDate',
        ],
        'closing_time' => [
            'title' => 'End Date',
            'present' => true,
            'field' => 'presentEndDate',
        ],
        'title' => [
            'title' => 'Closure Copy',
            'edit_link' => true,
            'sort' => false,
            'field' => 'closure_copy',
        ]
    ]
])
