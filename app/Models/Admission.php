<?php

namespace App\Models;

class Admission extends AbstractModel
{
    protected $fillable = [
        'published',
        'time_start',
        'time_end',
        'date',
        'title',
        'copy',
        'position',
        'page_id',
    ];

    /**
     * Those fields get auto set to null if not submitted
     */
    public $nullable = [];

    /**
     * Those fields get auto set to false if not submitted
     */
    public $checkboxes = ['published'];

    public $dates = ['date'];
}
