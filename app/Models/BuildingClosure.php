<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class BuildingClosure extends AbstractModel
{
    use Transformable;
    use HasFactory;

    protected $presenter = 'App\Presenters\BuildingClosurePresenter';
    protected $presenterAdmin = 'App\Presenters\BuildingClosurePresenter';

    protected $fillable = [
        'published',
        'date_start',
        'date_end',
        'closure_copy',
        'type',
        'hour_id'
    ];

    public static $types = [
        0 => 'Museum',
        1 => 'Shop',
        2 => 'Library',
    ];

    public $nullable = [];

    public $casts = [
        'published' => 'boolean',
        'date_start' => 'date',
        'date_end' => 'date',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'published' => true,
    ];

    public function scopeToday($query, $type = 0): Builder
    {
        $today = Carbon::today();

        return $query->published()
            ->where('type', $type)
            ->where('date_start', '<=', $today)
            ->where('date_end', '>=', $today);
    }

    protected function transformMappingInternal()
    {
        return [
            [
                'name' => 'published',
                'doc' => 'Published',
                'type' => 'boolean',
                'value' => function () {
                    return $this->published;
                },
            ],
            [
                'name' => 'date_start',
                'doc' => 'Start of closure',
                'type' => 'date',
                'value' => function () {
                    return $this->date_start;
                },
            ],
            [
                'name' => 'date_end',
                'doc' => 'End of closure',
                'type' => 'date',
                'value' => function () {
                    return $this->date_end;
                },
            ],
            [
                'name' => 'closure_copy',
                'doc' => 'Description of Closure',
                'type' => 'text',
                'value' => function () {
                    return $this->closure_copy;
                },
            ],
            [
                'name' => 'type',
                'doc' => 'Type of Closure',
                'type' => 'number',
                'value' => function () {
                    return $this->type;
                },
            ],
        ];
    }
}
