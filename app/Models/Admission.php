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

    // those fields get auto set to null if not submited
    public $nullable = [];

    // those fields get auto set to false if not submited
    public $checkboxes = ['published'];

    public $dates = ['date'];
}
