<?php

namespace App\Repositories;

use App\Models\EventProgram;
use Illuminate\Database\Eloquent\Builder;

class EventProgramRepository extends ModuleRepository
{
    public function __construct(EventProgram $model)
    {
        $this->model = $model;
    }

    public function order(Builder $query, array $orders = []): Builder
    {
        // Default sort by name instead of created_at.
        $orders['name'] ??= 'asc';
        unset($orders['created_at']);
        return parent::order($query, $orders);
    }
}
