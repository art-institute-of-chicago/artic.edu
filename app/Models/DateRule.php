<?php

namespace App\Models;

use App\Helpers\DateHelpers;

class DateRule extends AbstractModel
{
    protected $fillable = [
        'title',
        'start_date',
        'end_date',
        'type',
        'recurring_type',
        'every',
        'ocurrencies',
        'monthly_repeat_pattern',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
        'event_id',
    ];

    public static $ruleTypes = [
        0 => 'Recurring event',
        1 => 'Include specific date (all fields ignored except Start Date)',
        2 => 'Exclude specific date (all fields ignored except Start Date)',
    ];

    public static $recurringTypes = [
        0 => 'Days',
        1 => 'Week/s',
        2 => 'Month/s',
    ];

    public static $monthlyRepeat = [
        0 => 'Monthly on the numeric day selected as start date (every 1st, 2nd... etc)',
        1 => 'Monthly the first day of the week selected as start date (first Monday, first Tuesday... etc)',
    ];

    public $dates = ['start_date', 'end_date'];

    /**
     * Those fields get auto set to null if not submited
     */
    public $nullable = [];

    public $checkboxes = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

    public static function getRuleTypes()
    {
        return collect(self::$ruleTypes);
    }

    public static function getRecurringTypes()
    {
        return collect(self::$recurringTypes);
    }

    public static function getMonthlyRepeat()
    {
        return collect(self::$monthlyRepeat);
    }

    public function getRuleType()
    {
        switch ($this->type) {
            case 0:return 'recurrent';
            case 1:return 'include';
            case 2:return 'exclude';
        }
    }

    public function getMonthlyRepeatType()
    {
        switch ($this->monthly_repeat_pattern) {
            case 0:return 'numeral';
            case 1:return 'first_day';
        }
    }

    public function getRecurringType()
    {
        switch ($this->recurring_type) {
            case 0:return 'DAILY';
            case 1:return 'WEEKLY';
            case 2:return 'MONTHLY';
        }
    }

    public function getDays()
    {
        return array_filter(array_map(function ($element) {
            if ($this->{$element}) {
                return strtoupper(substr($element, 0, 2));
            }
        }, ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']));
    }

    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = DateHelpers::stripTime($value);
    }

    public function setEndDateAttribute($value)
    {
        $this->attributes['end_date'] = DateHelpers::stripTime($value);
    }

    public function getStartDateAttribute()
    {
        return DateHelpers::stripTime($this->attributes['start_date']);
    }

    public function getEndDateAttribute()
    {
        return DateHelpers::stripTime($this->attributes['end_date']);
    }
}
