@extends('cms-toolkit::layouts.resources.index', [
    'create' => true,
    'edit' => true,
    'delete' => true,
    'sort' => true,
    'search' => true,
    'publish' => true,
    'columns' => [
        'question' => [
            'title' => 'Question',
            'edit_link' => true,
            'field' => 'question',
        ],
        'answer' => [
            'title' => 'Answer',
            'edit_link' => true,
            'field' => 'answer',
        ]
    ]
])


