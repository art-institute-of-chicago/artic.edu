<?php

namespace App\Models;

use A17\CmsToolkit\Models\Model;
use A17\CmsToolkit\Models\Behaviors\HasPresenter;

class Closure extends Model
{
    use HasPresenter;

    protected $presenter = 'App\Presenters\ClosurePresenter';
    protected $presenterAdmin = 'App\Presenters\ClosurePresenter';

    protected $fillable = [
        'published',
        'date_start',
        'date_end',
        'closure_copy',
        'type'
    ];

    public static $types = [
        0 => 'Museum',
        1 => 'Shop',
        2 => 'Library'
    ];

    // those fields get auto set to null if not submited
    public $nullable = [];

    // those fields get auto set to false if not submited
    public $checkboxes = [];

    public $dates = ['date_start', 'date_end'];
}
