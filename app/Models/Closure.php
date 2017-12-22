<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasPresenter;
use A17\CmsToolkit\Models\Model;

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
        'type',
    ];

    public static $types = [
        0 => 'Museum',
        1 => 'Shop',
        2 => 'Library',
    ];

    public $nullable = [];

    public $checkboxes = ['published'];

    public $dates = ['date_start', 'date_end'];
}
