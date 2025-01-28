<?php

namespace App\Repositories;

use App\Models\SearchTerm;
use Illuminate\Database\Eloquent\Builder;

class SearchTermRepository extends ModuleRepository
{
    public function __construct(SearchTerm $model)
    {
        $this->model = $model;
    }

    public function order(Builder $query, array $orders = []): Builder
    {
        // Default sort by position instead of created_at.
        $orders['position'] ??= 'asc';
        unset($orders['created_at']);
        return parent::order($query, $orders);
    }
}
