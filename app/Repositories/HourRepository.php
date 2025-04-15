<?php

namespace App\Repositories;

use App\Models\Hour;

class HourRepository extends ModuleRepository
{
    public function __construct(Hour $model)
    {
        $this->model = $model;
    }

    protected array $repeaters = [
        'building_closures' => [
            'relation' => 'buildingClosures'
        ],
    ];
}
