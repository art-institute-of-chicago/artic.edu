<?php

namespace App\Repositories;

use App\Models\Fee;
use Illuminate\Database\Eloquent\Builder;

class FeeRepository extends ModuleRepository
{
    public function __construct(Fee $model)
    {
        $this->model = $model;
    }

    public function order(Builder $query, array $orders = []): Builder
    {
        $orders['fee_category_id'] ??= 'asc';
        $orders['fee_age_id'] ??= 'asc';
        $orders['fee_age_id'] ??= 'asc';
        unset($orders['created_at']);
        return parent::order($query, $orders);
    }
}
