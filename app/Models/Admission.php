<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasPresenter;

class Admission extends AbstractModel
{
    use HasPresenter;

    protected $fillable = [
        'published',
        'time_start',
        'time_end',
        'date',
        'title',
        'copy',
        'position',
        'page_id',
        'landing_page_id',
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
