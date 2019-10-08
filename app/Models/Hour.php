<?php

namespace App\Models;

use Carbon\Carbon;

class Hour extends AbstractModel
{
    use Transformable;

    protected $presenter = 'App\Presenters\HoursPresenter';
    protected $presenterAdmin = 'App\Presenters\HoursPresenter';

    protected $fillable = [
        'valid_from',
        'valid_through',
        'type',
        'title',
        'url',
        'published',
    ];

    public static $types = [
        0 => 'Museum',
        1 => 'Shop',
        2 => 'Library',
    ];

    public $dates = ['valid_from', 'valid_through'];

    // those fields get auto set to null if not submited
    public $nullable = [];

    // those fields get auto set to false if not submited
    public $checkboxes = ['published'];

    public function scopeToday($query, $type = 0)
    {
        $today = Carbon::today();

        $queryModified = clone $query;
        $queryModified
            ->published()
            ->where('type', $type)
            ->whereDate('valid_from', '<=', $today)
            ->whereDate('valid_through', '>=', $today);

        return $queryModified->exists() ? $queryModified : $this->scopeDefault($query, $type);
    }

    public function scopeDefault($query, $type = 0)
    {
        return $query
            ->published()
            ->where('type', $type)
            ->whereNull('valid_from')
            ->whereNull('valid_through');
    }

    protected function transformMappingInternal()
    {
        return [
            [
                "name" => 'valid_from',
                "doc" => "Valid From",
                "type" => "datetime",
                "value" => function () {return $this->valid_from;},
            ],
            [
                "name" => 'valid_through',
                "doc" => "Valid Through",
                "type" => "datetime",
                "value" => function () {return $this->valid_through;},
            ],
            [
                "name" => 'type',
                "doc" => "Type",
                "type" => "number",
                "value" => function () {return $this->type;},
            ],
            [
                "name" => 'title',
                "doc" => "Title",
                "type" => "string",
                "value" => function () {return $this->title;},
            ],
            [
                "name" => 'url',
                "doc" => "URL",
                "type" => "string",
                "value" => function () {return $this->url;},
            ],
            [
                "name" => 'published',
                "doc" => "Published",
                "type" => "boolean",
                "value" => function () {return $this->published;},
            ],
        ];
    }

    public static function getOpening()
    {
        $hour = Hour::today()->first();
        return $hour->title ?? 'Open daily 10:30&ndash;5:00';
    }

    public static function getOpeningUnlessClosure()
    {
        $closure = Closure::today()->first();

        return $closure ? null : self::getOpening();
    }

    public static function getOpeningUrl()
    {
        $hour = Hour::today()->first();
        return $hour->url ?? 'visit';
    }

}
