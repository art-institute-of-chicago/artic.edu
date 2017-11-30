@extends('cms-toolkit::layouts.resources.index', [
    'title' => "Weekly Calendar Item",
    'create' => true,
    'edit' => true,
    'delete' => false,
    'sort' => false,
    'search' => false,
    'publish' => false,
    'columns' => [
        'type' => [
            'title' => 'Type',
            'present' => true,
            'field' => 'presentType',
            'edit_link' => true,
        ],
        'day_of_week' => [
            'title' => 'Day of Week',
            'present' => true,
            'field' => 'dayOfWeek',
            'edit_link' => true,
        ],
        'closed' => [
            'title' => 'Open/Closed',
            'present' => true,
            'field' => 'presentClosed',
        ],
        'opening_time' => [
            'title' => 'Opening Time',
            'present' => true,
            'field' => 'presentOpeningTime',
        ],
        'closing_time' => [
            'title' => 'Closing Time',
            'present' => true,
            'field' => 'presentClosingTime',
        ]
    ]
])
