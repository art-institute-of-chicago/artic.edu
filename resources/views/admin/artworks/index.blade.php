@extends('cms-toolkit::layouts.resources.index', [
    'create' => true,
    'edit' => true,
    'delete' => true,
    'sort' => false,
    'search' => true,
    'publish' => false,
    'columns' => [
        'title' => [
            'title' => 'Title',
            'edit_link' => true,
            'sort' => true,
            'field' => 'title',
        ],
        'datahub_id' => [
            'title' => 'Datahub ID',
            'edit_link' => true,
            'sort' => true,
            'field' => 'datahub_id',
        ]
    ]
])


