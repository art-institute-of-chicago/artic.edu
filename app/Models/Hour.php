<?php

namespace App\Models;

use A17\CmsToolkit\Models\Model;
use A17\CmsToolkit\Models\Behaviors\HasPresenter;

class Hour extends Model
{
    use HasPresenter;

    protected $presenter = 'App\Presenters\HoursPresenter';
    protected $presenterAdmin = 'App\Presenters\HoursPresenter';

    static $days = array(
        0 => 'Sunday',
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday'
    );

    protected $fillable = [
        'day_of_week',
        'opening_time',
        'closing_time',
        'type'
    ];

    public static $types = [
        0 => 'Museum',
        1 => 'Shop',
        2 => 'Library'
    ];

    public $dates = ['opening_time', 'closing_time'];

    // those fields get auto set to null if not submited
    public $nullable = [];

    // those fields get auto set to false if not submited
    public $checkboxes = [];

}
